/*
* jQuery Tumblr RSS Plugin 1.1
* 
* Copyright 2011 Jason Graves (GodLikeMouse)
* 
* Licensed under the Apache License, Version 2.0; you may not use this file except in compliance with the License.
* http://www.apache.org/licenses/LICENSE-2.0
* 
* Source: http://www.godlikemouse.com/code/jquery-ui-tumblr-rss/
* Version: 1.1
* 
* Simple API for retrieving a user's tweets
* 
* Examples
*   1) Populate an element with 5 of a user's tumblr posts.
*
*      -- Example HTML --
*      <div id="myUserPosts"/>
*
*      $(function(){
*          $("#myUserPosts").tumblrRss({username: "godliikemouse", limit: 5});
*      });
*      
*   2) Populate all elements of a specific class with the tumblr posts
*      by tag parameters.
*
*      -- Example HTML --
*      <div class="myUserPosts" tumblr-username="godliikemouse" tumblr-limit="5" />
*
*      $(function(){
*          $(".myUserPosts").tumblrRss();
*      });
*/

$.fn.tumblrRss = function(options){

    if(options){
        //options configured
        options.username = options.username ? options.username : null;
        if(!options.username) throw "jquery.ui.tumblr.rss.js: username required.";
    
        options.tagged = options.tagged ? options.tagged : null;
        options.language = options.language ? options.language : "en-us";
        options.template = options.template ? options.template : $.fn.tumblrRss.defaultTemplate;
        options.context = options.context ? options.context : this;
        options.offset = options.offset ? options.offset : 0;
        options.limit = options.limit ? options.limit : 25;
        options.url = options.url ? options.url : "http://" + options.username + ".tumblr.com/api/read/json";
        options.callback = options.callback ? options.callback : null;
    }
    else{
        options = {};
        //tumblr-param configured
        options.username = $(this).attr("tumblr-username") ? $(this).attr("tumblr-username") : null;
        if(!options.username) throw "jquery.ui.tumblr.rss.js: username required.";
        
        options.tagged = $(this).attr("tumblr-tagged") ? $(this).attr("tumblr-tagged") : null;
        options.language = $(this).attr("tumblr-language") ? $(this).attr("tumblr-language") : "en-us";
        options.template = $(this).attr("tumblr-template") ? $(this).attr("tumblr-template") : $.fn.tumblrRss.defaultTemplate;
        options.context = this;
        options.offset = $(this).attr("tumblr-offset") ? $(this).attr("tumblr-offset") : 0;
        options.limit = $(this).attr("tumblr-limit") ? $(this).attr("tumblr-limit") : 25;
        options.url = $(this).attr("tumblr-url") ? $(this).attr("tumblr-url") : "http://" + options.username + ".tumblr.com/api/read/json";
        options.callback = null;
    }//end if
    
    function applyTemplate(t, e, p){
        for(var i in e){
            var v = e[i];
            
            if(typeof(v) == "string" || typeof(v) == "number"){
                var lookup = "{" + p + "." + i + "}";
                while(t.indexOf(lookup) >= 0)
                    t = t.replace(lookup, v);
            }//end if
            
            if(typeof(v) == "object"){
                t = applyTemplate(t, v, p + "." + i);
            }//end if
        }//end for
        
        return t;
    }//end applyTemplate()
    
    var ajaxData = {
        num: options.limit,
        start: options.offset,
    };
    
    if(options.tagged)
        ajaxData.tagged = options.tagged;
    
    $.ajax({
        url: options.url,
        dataType: "jsonp",
        data: ajaxData,
        success: function(data){
            if(options.callback) return options.callback(data);
            var output = '';
            
            var len = data.posts.length;
            for(var i=0; i<len; i++){
                var entry = data.posts[i];

                entry.username = options.username;
                var t = options.template;
                
                t = applyTemplate(t, entry, 'entry');
                    
                output += t;
            }//end for
            
            output = output.replace(/{[A-Za-z0-9.\-]+}/gim, '');
            
            options.context.html(output);
        }//end success()
    });

}//end tumblrRss

$.fn.tumblrRss.defaultTemplate = '<div class="jquery-ui-tumblr-rss-entry"><cite><a href="http://{entry.username}.tumblr.com" class="profileLink">{entry.username}</a></cite> <time>{entry.date-gmt}</time> <img src="{entry.photo-url-75}" onerror="$(this).hide();" class="photo" /> <span class="video">{entry.video-player}</span> <span class="audioCaption">{entry.audio-caption}</span> <span class="audioPlayer">{entry.audio-player}</span> <span class="regularTitle">{entry.regular-title}</span> <span class="regularBody">{entry.regular-body}</span> <a href="{entry.link-url}" class="link">{entry.link-text}</a><span class="linkDescription">{entry.link-description}</span> <span class="conversationTitle">{entry.conversation-title}</span> <span class="conversationText">{entry.conversation-text}</span> <quote>{entry.quote-text}</quote> <a href="{entry.url-with-slug}" class="postLink">View Post</a></div>';