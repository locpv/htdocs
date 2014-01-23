/*
 * jPlayer Plugin for jQuery JavaScript Library
 * http://www.jplayer.org
 *
 * Copyright (c) 2009 - 2011 Happyworm Ltd
 * Dual licensed under the MIT and GPL licenses.
 *  - http://www.opensource.org/licenses/mit-license.php
 *  - http://www.gnu.org/copyleft/gpl.html
 *
 * Author: Mark J Panaghiston
 * Version: 2.1.0
 * Date: 1st September 2011
 */

(function(b,f){b.fn.jPlayer=function(a){var c=typeof a==="string",d=Array.prototype.slice.call(arguments,1),e=this,a=!c&&d.length?b.extend.apply(null,[!0,a].concat(d)):a;if(c&&a.charAt(0)==="_")return e;c?this.each(function(){var c=b.data(this,"jPlayer"),h=c&&b.isFunction(c[a])?c[a].apply(c,d):c;if(h!==c&&h!==f)return e=h,!1}):this.each(function(){var c=b.data(this,"jPlayer");c?c.option(a||{}):b.data(this,"jPlayer",new b.jPlayer(a,this))});return e};b.jPlayer=function(a,c){if(arguments.length){this.element=
b(c);this.options=b.extend(!0,{},this.options,a);var d=this;this.element.bind("remove.jPlayer",function(){d.destroy()});this._init()}};b.jPlayer.emulateMethods="load play pause";b.jPlayer.emulateStatus="src readyState networkState currentTime duration paused ended playbackRate";b.jPlayer.emulateOptions="muted volume";b.jPlayer.reservedEvent="ready flashreset resize repeat error warning";b.jPlayer.event={ready:"jPlayer_ready",flashreset:"jPlayer_flashreset",resize:"jPlayer_resize",repeat:"jPlayer_repeat",
click:"jPlayer_click",error:"jPlayer_error",warning:"jPlayer_warning",loadstart:"jPlayer_loadstart",progress:"jPlayer_progress",suspend:"jPlayer_suspend",abort:"jPlayer_abort",emptied:"jPlayer_emptied",stalled:"jPlayer_stalled",play:"jPlayer_play",pause:"jPlayer_pause",loadedmetadata:"jPlayer_loadedmetadata",loadeddata:"jPlayer_loadeddata",waiting:"jPlayer_waiting",playing:"jPlayer_playing",canplay:"jPlayer_canplay",canplaythrough:"jPlayer_canplaythrough",seeking:"jPlayer_seeking",seeked:"jPlayer_seeked",
timeupdate:"jPlayer_timeupdate",ended:"jPlayer_ended",ratechange:"jPlayer_ratechange",durationchange:"jPlayer_durationchange",volumechange:"jPlayer_volumechange"};b.jPlayer.htmlEvent="loadstart,abort,emptied,stalled,loadedmetadata,loadeddata,canplay,canplaythrough,ratechange".split(",");b.jPlayer.pause=function(){b.each(b.jPlayer.prototype.instances,function(a,b){b.data("jPlayer").status.srcSet&&b.jPlayer("pause")})};b.jPlayer.timeFormat={showHour:!1,showMin:!0,showSec:!0,padHour:!1,padMin:!0,padSec:!0,
sepHour:":",sepMin:":",sepSec:""};b.jPlayer.convertTime=function(a){var c=new Date(a*1E3),d=c.getUTCHours(),a=c.getUTCMinutes(),c=c.getUTCSeconds(),d=b.jPlayer.timeFormat.padHour&&d<10?"0"+d:d,a=b.jPlayer.timeFormat.padMin&&a<10?"0"+a:a,c=b.jPlayer.timeFormat.padSec&&c<10?"0"+c:c;return(b.jPlayer.timeFormat.showHour?d+b.jPlayer.timeFormat.sepHour:"")+(b.jPlayer.timeFormat.showMin?a+b.jPlayer.timeFormat.sepMin:"")+(b.jPlayer.timeFormat.showSec?c+b.jPlayer.timeFormat.sepSec:"")};b.jPlayer.uaBrowser=
function(a){var a=a.toLowerCase(),b=/(opera)(?:.*version)?[ \/]([\w.]+)/,d=/(msie) ([\w.]+)/,e=/(mozilla)(?:.*? rv:([\w.]+))?/,a=/(webkit)[ \/]([\w.]+)/.exec(a)||b.exec(a)||d.exec(a)||a.indexOf("compatible")<0&&e.exec(a)||[];return{browser:a[1]||"",version:a[2]||"0"}};b.jPlayer.uaPlatform=function(a){var b=a.toLowerCase(),d=/(android)/,e=/(mobile)/,a=/(ipad|iphone|ipod|android|blackberry|playbook|windows ce|webos)/.exec(b)||[],b=/(ipad|playbook)/.exec(b)||!e.exec(b)&&d.exec(b)||[];a[1]&&(a[1]=a[1].replace(/\s/g,
"_"));return{platform:a[1]||"",tablet:b[1]||""}};b.jPlayer.browser={};b.jPlayer.platform={};var i=b.jPlayer.uaBrowser(navigator.userAgent);if(i.browser)b.jPlayer.browser[i.browser]=!0,b.jPlayer.browser.version=i.version;i=b.jPlayer.uaPlatform(navigator.userAgent);if(i.platform)b.jPlayer.platform[i.platform]=!0,b.jPlayer.platform.mobile=!i.tablet,b.jPlayer.platform.tablet=!!i.tablet;b.jPlayer.prototype={count:0,version:{script:"2.1.0",needFlash:"2.1.0",flash:"unknown"},options:{swfPath:"js",solution:"html, flash",
supplied:"mp3",preload:"metadata",volume:0.8,muted:!1,wmode:"opaque",backgroundColor:"#000000",cssSelectorAncestor:"#jp_container_1",cssSelector:{videoPlay:".jp-video-play",play:".jp-play",pause:".jp-pause",stop:".jp-stop",seekBar:".jp-seek-bar",playBar:".jp-play-bar",mute:".jp-mute",unmute:".jp-unmute",volumeBar:".jp-volume-bar",volumeBarValue:".jp-volume-bar-value",volumeMax:".jp-volume-max",currentTime:".jp-current-time",duration:".jp-duration",fullScreen:".jp-full-screen",restoreScreen:".jp-restore-screen",
repeat:".jp-repeat",repeatOff:".jp-repeat-off",gui:".jp-gui",noSolution:".jp-no-solution"},fullScreen:!1,autohide:{restored:!1,full:!0,fadeIn:200,fadeOut:600,hold:1E3},loop:!1,repeat:function(a){a.jPlayer.options.loop?b(this).unbind(".jPlayerRepeat").bind(b.jPlayer.event.ended+".jPlayer.jPlayerRepeat",function(){b(this).jPlayer("play")}):b(this).unbind(".jPlayerRepeat")},nativeVideoControls:{},noFullScreen:{msie:/msie [0-6]/,ipad:/ipad.*?os [0-4]/,iphone:/iphone/,ipod:/ipod/,android_pad:/android [0-3](?!.*?mobile)/,
android_phone:/android.*?mobile/,blackberry:/blackberry/,windows_ce:/windows ce/,webos:/webos/},noVolume:{ipad:/ipad/,iphone:/iphone/,ipod:/ipod/,android_pad:/android(?!.*?mobile)/,android_phone:/android.*?mobile/,blackberry:/blackberry/,windows_ce:/windows ce/,webos:/webos/,playbook:/playbook/},verticalVolume:!1,idPrefix:"jp",noConflict:"jQuery",emulateHtml:!1,errorAlerts:!1,warningAlerts:!1},optionsAudio:{size:{width:"0px",height:"0px",cssClass:""},sizeFull:{width:"0px",height:"0px",cssClass:""}},
optionsVideo:{size:{width:"480px",height:"270px",cssClass:"jp-video-270p"},sizeFull:{width:"100%",height:"100%",cssClass:"jp-video-full"}},instances:{},status:{src:"",media:{},paused:!0,format:{},formatType:"",waitForPlay:!0,waitForLoad:!0,srcSet:!1,video:!1,seekPercent:0,currentPercentRelative:0,currentPercentAbsolute:0,currentTime:0,duration:0,readyState:0,networkState:0,playbackRate:1,ended:0},internal:{ready:!1},solution:{html:!0,flash:!0},format:{mp3:{codec:'audio/mpeg; codecs="mp3"',flashCanPlay:!0,
media:"audio"},m4a:{codec:'audio/mp4; codecs="mp4a.40.2"',flashCanPlay:!0,media:"audio"},oga:{codec:'audio/ogg; codecs="vorbis"',flashCanPlay:!1,media:"audio"},wav:{codec:'audio/wav; codecs="1"',flashCanPlay:!1,media:"audio"},webma:{codec:'audio/webm; codecs="vorbis"',flashCanPlay:!1,media:"audio"},fla:{codec:"audio/x-flv",flashCanPlay:!0,media:"audio"},m4v:{codec:'video/mp4; codecs="avc1.42E01E, mp4a.40.2"',flashCanPlay:!0,media:"video"},ogv:{codec:'video/ogg; codecs="theora, vorbis"',flashCanPlay:!1,
media:"video"},webmv:{codec:'video/webm; codecs="vorbis, vp8"',flashCanPlay:!1,media:"video"},flv:{codec:"video/x-flv",flashCanPlay:!0,media:"video"}},_init:function(){var a=this;this.element.empty();this.status=b.extend({},this.status);this.internal=b.extend({},this.internal);this.internal.domNode=this.element.get(0);this.formats=[];this.solutions=[];this.require={};this.htmlElement={};this.html={};this.html.audio={};this.html.video={};this.flash={};this.css={};this.css.cs={};this.css.jq={};this.ancestorJq=
[];this.options.volume=this._limitValue(this.options.volume,0,1);b.each(this.options.supplied.toLowerCase().split(","),function(c,d){var e=d.replace(/^\s+|\s+$/g,"");if(a.format[e]){var f=!1;b.each(a.formats,function(a,b){if(e===b)return f=!0,!1});f||a.formats.push(e)}});b.each(this.options.solution.toLowerCase().split(","),function(c,d){var e=d.replace(/^\s+|\s+$/g,"");if(a.solution[e]){var f=!1;b.each(a.solutions,function(a,b){if(e===b)return f=!0,!1});f||a.solutions.push(e)}});this.internal.instance=
"jp_"+this.count;this.instances[this.internal.instance]=this.element;this.element.attr("id")||this.element.attr("id",this.options.idPrefix+"_jplayer_"+this.count);this.internal.self=b.extend({},{id:this.element.attr("id"),jq:this.element});this.internal.audio=b.extend({},{id:this.options.idPrefix+"_audio_"+this.count,jq:f});this.internal.video=b.extend({},{id:this.options.idPrefix+"_video_"+this.count,jq:f});this.internal.flash=b.extend({},{id:this.options.idPrefix+"_flash_"+this.count,jq:f,swf:this.options.swfPath+
(this.options.swfPath.toLowerCase().slice(-4)!==".swf"?(this.options.swfPath&&this.options.swfPath.slice(-1)!=="/"?"/":"")+"Jplayer.swf":"")});this.internal.poster=b.extend({},{id:this.options.idPrefix+"_poster_"+this.count,jq:f});b.each(b.jPlayer.event,function(b,c){a.options[b]!==f&&(a.element.bind(c+".jPlayer",a.options[b]),a.options[b]=f)});this.require.audio=!1;this.require.video=!1;b.each(this.formats,function(b,c){a.require[a.format[c].media]=!0});this.options=this.require.video?b.extend(!0,
{},this.optionsVideo,this.options):b.extend(!0,{},this.optionsAudio,this.options);this._setSize();this.status.nativeVideoControls=this._uaBlocklist(this.options.nativeVideoControls);this.status.noFullScreen=this._uaBlocklist(this.options.noFullScreen);this.status.noVolume=this._uaBlocklist(this.options.noVolume);this._restrictNativeVideoControls();this.htmlElement.poster=document.createElement("img");this.htmlElement.poster.id=this.internal.poster.id;this.htmlElement.poster.onload=function(){(!a.status.video||
a.status.waitForPlay)&&a.internal.poster.jq.show()};this.element.append(this.htmlElement.poster);this.internal.poster.jq=b("#"+this.internal.poster.id);this.internal.poster.jq.css({width:this.status.width,height:this.status.height});this.internal.poster.jq.hide();this.internal.poster.jq.bind("click.jPlayer",function(){a._trigger(b.jPlayer.event.click)});this.html.audio.available=!1;if(this.require.audio)this.htmlElement.audio=document.createElement("audio"),this.htmlElement.audio.id=this.internal.audio.id,
this.html.audio.available=!!this.htmlElement.audio.canPlayType&&this._testCanPlayType(this.htmlElement.audio);this.html.video.available=!1;if(this.require.video)this.htmlElement.video=document.createElement("video"),this.htmlElement.video.id=this.internal.video.id,this.html.video.available=!!this.htmlElement.video.canPlayType&&this._testCanPlayType(this.htmlElement.video);this.flash.available=this._checkForFlash(10);this.html.canPlay={};this.flash.canPlay={};b.each(this.formats,function(b,c){a.html.canPlay[c]=
a.html[a.format[c].media].available&&""!==a.htmlElement[a.format[c].media].canPlayType(a.format[c].codec);a.flash.canPlay[c]=a.format[c].flashCanPlay&&a.flash.available});this.html.desired=!1;this.flash.desired=!1;b.each(this.solutions,function(c,d){if(c===0)a[d].desired=!0;else{var e=!1,f=!1;b.each(a.formats,function(b,c){a[a.solutions[0]].canPlay[c]&&(a.format[c].media==="video"?f=!0:e=!0)});a[d].desired=a.require.audio&&!e||a.require.video&&!f}});this.html.support={};this.flash.support={};b.each(this.formats,
function(b,c){a.html.support[c]=a.html.canPlay[c]&&a.html.desired;a.flash.support[c]=a.flash.canPlay[c]&&a.flash.desired});this.html.used=!1;this.flash.used=!1;b.each(this.solutions,function(c,d){b.each(a.formats,function(b,c){if(a[d].support[c])return a[d].used=!0,!1})});this._resetActive();this._resetGate();this._cssSelectorAncestor(this.options.cssSelectorAncestor);!this.html.used&&!this.flash.used?(this._error({type:b.jPlayer.error.NO_SOLUTION,context:"{solution:'"+this.options.solution+"', supplied:'"+
this.options.supplied+"'}",message:b.jPlayer.errorMsg.NO_SOLUTION,hint:b.jPlayer.errorHint.NO_SOLUTION}),this.css.jq.noSolution.length&&this.css.jq.noSolution.show()):this.css.jq.noSolution.length&&this.css.jq.noSolution.hide();if(this.flash.used){var c,d="jQuery="+encodeURI(this.options.noConflict)+"&id="+encodeURI(this.internal.self.id)+"&vol="+this.options.volume+"&muted="+this.options.muted;if(b.browser.msie&&Number(b.browser.version)<=8){d=['<param name="movie" value="'+this.internal.flash.swf+
'" />','<param name="FlashVars" value="'+d+'" />','<param name="allowScriptAccess" value="always" />','<param name="bgcolor" value="'+this.options.backgroundColor+'" />','<param name="wmode" value="'+this.options.wmode+'" />'];c=document.createElement('<object id="'+this.internal.flash.id+'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="0" height="0"></object>');for(var e=0;e<d.length;e++)c.appendChild(document.createElement(d[e]))}else e=function(a,b,c){var d=document.createElement("param");
d.setAttribute("name",b);d.setAttribute("value",c);a.appendChild(d)},c=document.createElement("object"),c.setAttribute("id",this.internal.flash.id),c.setAttribute("data",this.internal.flash.swf),c.setAttribute("type","application/x-shockwave-flash"),c.setAttribute("width","1"),c.setAttribute("height","1"),e(c,"flashvars",d),e(c,"allowscriptaccess","always"),e(c,"bgcolor",this.options.backgroundColor),e(c,"wmode",this.options.wmode);this.element.append(c);this.internal.flash.jq=b(c)}if(this.html.used){if(this.html.audio.available)this._addHtmlEventListeners(this.htmlElement.audio,
this.html.audio),this.element.append(this.htmlElement.audio),this.internal.audio.jq=b("#"+this.internal.audio.id);if(this.html.video.available)this._addHtmlEventListeners(this.htmlElement.video,this.html.video),this.element.append(this.htmlElement.video),this.internal.video.jq=b("#"+this.internal.video.id),this.status.nativeVideoControls?this.internal.video.jq.css({width:this.status.width,height:this.status.height}):this.internal.video.jq.css({width:"0px",height:"0px"}),this.internal.video.jq.bind("click.jPlayer",
function(){a._trigger(b.jPlayer.event.click)})}this.options.emulateHtml&&this._emulateHtmlBridge();this.html.used&&!this.flash.used&&setTimeout(function(){a.internal.ready=!0;a.version.flash="n/a";a._trigger(b.jPlayer.event.repeat);a._trigger(b.jPlayer.event.ready)},100);this._updateNativeVideoControls();this._updateInterface();this._updateButtons(!1);this._updateAutohide();this._updateVolume(this.options.volume);this._updateMute(this.options.muted);this.css.jq.videoPlay.length&&this.css.jq.videoPlay.hide();
b.jPlayer.prototype.count++},destroy:function(){this.clearMedia();this._removeUiClass();this.css.jq.currentTime.length&&this.css.jq.currentTime.text("");this.css.jq.duration.length&&this.css.jq.duration.text("");b.each(this.css.jq,function(a,b){b.length&&b.unbind(".jPlayer")});this.internal.poster.jq.unbind(".jPlayer");this.internal.video.jq&&this.internal.video.jq.unbind(".jPlayer");this.options.emulateHtml&&this._destroyHtmlBridge();this.element.removeData("jPlayer");this.element.unbind(".jPlayer");
this.element.empty();delete this.instances[this.internal.instance]},enable:function(){},disable:function(){},_testCanPlayType:function(a){try{return a.canPlayType(this.format.mp3.codec),!0}catch(b){return!1}},_uaBlocklist:function(a){var c=navigator.userAgent.toLowerCase(),d=!1;b.each(a,function(a,b){if(b&&b.test(c))return d=!0,!1});return d},_restrictNativeVideoControls:function(){if(this.require.audio&&this.status.nativeVideoControls)this.status.nativeVideoControls=!1,this.status.noFullScreen=!0},
_updateNativeVideoControls:function(){if(this.html.video.available&&this.html.used)this.htmlElement.video.controls=this.status.nativeVideoControls,this._updateAutohide(),this.status.nativeVideoControls&&this.require.video?(this.internal.poster.jq.hide(),this.internal.video.jq.css({width:this.status.width,height:this.status.height})):this.status.waitForPlay&&this.status.video&&(this.internal.poster.jq.show(),this.internal.video.jq.css({width:"0px",height:"0px"}))},_addHtmlEventListeners:function(a,
c){var d=this;a.preload=this.options.preload;a.muted=this.options.muted;a.volume=this.options.volume;a.addEventListener("progress",function(){c.gate&&(d._getHtmlStatus(a),d._updateInterface(),d._trigger(b.jPlayer.event.progress))},!1);a.addEventListener("timeupdate",function(){c.gate&&(d._getHtmlStatus(a),d._updateInterface(),d._trigger(b.jPlayer.event.timeupdate))},!1);a.addEventListener("durationchange",function(){if(c.gate)d.status.duration=this.duration,d._getHtmlStatus(a),d._updateInterface(),
d._trigger(b.jPlayer.event.durationchange)},!1);a.addEventListener("play",function(){c.gate&&(d._updateButtons(!0),d._html_checkWaitForPlay(),d._trigger(b.jPlayer.event.play))},!1);a.addEventListener("playing",function(){c.gate&&(d._updateButtons(!0),d._seeked(),d._trigger(b.jPlayer.event.playing))},!1);a.addEventListener("pause",function(){c.gate&&(d._updateButtons(!1),d._trigger(b.jPlayer.event.pause))},!1);a.addEventListener("waiting",function(){c.gate&&(d._seeking(),d._trigger(b.jPlayer.event.waiting))},
!1);a.addEventListener("seeking",function(){c.gate&&(d._seeking(),d._trigger(b.jPlayer.event.seeking))},!1);a.addEventListener("seeked",function(){c.gate&&(d._seeked(),d._trigger(b.jPlayer.event.seeked))},!1);a.addEventListener("volumechange",function(){if(c.gate)d.options.volume=a.volume,d.options.muted=a.muted,d._updateMute(),d._updateVolume(),d._trigger(b.jPlayer.event.volumechange)},!1);a.addEventListener("suspend",function(){c.gate&&(d._seeked(),d._trigger(b.jPlayer.event.suspend))},!1);a.addEventListener("ended",
function(){if(c.gate){if(!b.jPlayer.browser.webkit)d.htmlElement.media.currentTime=0;d.htmlElement.media.pause();d._updateButtons(!1);d._getHtmlStatus(a,!0);d._updateInterface();d._trigger(b.jPlayer.event.ended)}},!1);a.addEventListener("error",function(){if(c.gate&&(d._updateButtons(!1),d._seeked(),d.status.srcSet))clearTimeout(d.internal.htmlDlyCmdId),d.status.waitForLoad=!0,d.status.waitForPlay=!0,d.status.video&&!d.status.nativeVideoControls&&d.internal.video.jq.css({width:"0px",height:"0px"}),
d._validString(d.status.media.poster)&&!d.status.nativeVideoControls&&d.internal.poster.jq.show(),d.css.jq.videoPlay.length&&d.css.jq.videoPlay.show(),d._error({type:b.jPlayer.error.URL,context:d.status.src,message:b.jPlayer.errorMsg.URL,hint:b.jPlayer.errorHint.URL})},!1);b.each(b.jPlayer.htmlEvent,function(e,g){a.addEventListener(this,function(){c.gate&&d._trigger(b.jPlayer.event[g])},!1)})},_getHtmlStatus:function(a,b){var d=0,e=0,g=0,f=0;if(a.duration)this.status.duration=a.duration;d=a.currentTime;
e=this.status.duration>0?100*d/this.status.duration:0;typeof a.seekable==="object"&&a.seekable.length>0?(g=this.status.duration>0?100*a.seekable.end(a.seekable.length-1)/this.status.duration:100,f=100*a.currentTime/a.seekable.end(a.seekable.length-1)):(g=100,f=e);b&&(e=f=d=0);this.status.seekPercent=g;this.status.currentPercentRelative=f;this.status.currentPercentAbsolute=e;this.status.currentTime=d;this.status.readyState=a.readyState;this.status.networkState=a.networkState;this.status.playbackRate=
a.playbackRate;this.status.ended=a.ended},_resetStatus:function(){this.status=b.extend({},this.status,b.jPlayer.prototype.status)},_trigger:function(a,c,d){a=b.Event(a);a.jPlayer={};a.jPlayer.version=b.extend({},this.version);a.jPlayer.options=b.extend(!0,{},this.options);a.jPlayer.status=b.extend(!0,{},this.status);a.jPlayer.html=b.extend(!0,{},this.html);a.jPlayer.flash=b.extend(!0,{},this.flash);if(c)a.jPlayer.error=b.extend({},c);if(d)a.jPlayer.warning=b.extend({},d);this.element.trigger(a)},
jPlayerFlashEvent:function(a,c){if(a===b.jPlayer.event.ready)if(this.internal.ready){if(this.flash.gate){if(this.status.srcSet){var d=this.status.currentTime,e=this.status.paused;this.setMedia(this.status.media);d>0&&(e?this.pause(d):this.play(d))}this._trigger(b.jPlayer.event.flashreset)}}else this.internal.ready=!0,this.internal.flash.jq.css({width:"0px",height:"0px"}),this.version.flash=c.version,this.version.needFlash!==this.version.flash&&this._error({type:b.jPlayer.error.VERSION,context:this.version.flash,
message:b.jPlayer.errorMsg.VERSION+this.version.flash,hint:b.jPlayer.errorHint.VERSION}),this._trigger(b.jPlayer.event.repeat),this._trigger(a);if(this.flash.gate)switch(a){case b.jPlayer.event.progress:this._getFlashStatus(c);this._updateInterface();this._trigger(a);break;case b.jPlayer.event.timeupdate:this._getFlashStatus(c);this._updateInterface();this._trigger(a);break;case b.jPlayer.event.play:this._seeked();this._updateButtons(!0);this._trigger(a);break;case b.jPlayer.event.pause:this._updateButtons(!1);
this._trigger(a);break;case b.jPlayer.event.ended:this._updateButtons(!1);this._trigger(a);break;case b.jPlayer.event.click:this._trigger(a);break;case b.jPlayer.event.error:this.status.waitForLoad=!0;this.status.waitForPlay=!0;this.status.video&&this.internal.flash.jq.css({width:"0px",height:"0px"});this._validString(this.status.media.poster)&&this.internal.poster.jq.show();this.css.jq.videoPlay.length&&this.status.video&&this.css.jq.videoPlay.show();this.status.video?this._flash_setVideo(this.status.media):
this._flash_setAudio(this.status.media);this._updateButtons(!1);this._error({type:b.jPlayer.error.URL,context:c.src,message:b.jPlayer.errorMsg.URL,hint:b.jPlayer.errorHint.URL});break;case b.jPlayer.event.seeking:this._seeking();this._trigger(a);break;case b.jPlayer.event.seeked:this._seeked();this._trigger(a);break;case b.jPlayer.event.ready:break;default:this._trigger(a)}return!1},_getFlashStatus:function(a){this.status.seekPercent=a.seekPercent;this.status.currentPercentRelative=a.currentPercentRelative;
this.status.currentPercentAbsolute=a.currentPercentAbsolute;this.status.currentTime=a.currentTime;this.status.duration=a.duration;this.status.readyState=4;this.status.networkState=0;this.status.playbackRate=1;this.status.ended=!1},_updateButtons:function(a){if(a!==f)this.status.paused=!a,this.css.jq.play.length&&this.css.jq.pause.length&&(a?(this.css.jq.play.hide(),this.css.jq.pause.show()):(this.css.jq.play.show(),this.css.jq.pause.hide()));this.css.jq.restoreScreen.length&&this.css.jq.fullScreen.length&&
(this.status.noFullScreen?(this.css.jq.fullScreen.hide(),this.css.jq.restoreScreen.hide()):this.options.fullScreen?(this.css.jq.fullScreen.hide(),this.css.jq.restoreScreen.show()):(this.css.jq.fullScreen.show(),this.css.jq.restoreScreen.hide()));this.css.jq.repeat.length&&this.css.jq.repeatOff.length&&(this.options.loop?(this.css.jq.repeat.hide(),this.css.jq.repeatOff.show()):(this.css.jq.repeat.show(),this.css.jq.repeatOff.hide()))},_updateInterface:function(){this.css.jq.seekBar.length&&this.css.jq.seekBar.width(this.status.seekPercent+
"%");this.css.jq.playBar.length&&this.css.jq.playBar.width(this.status.currentPercentRelative+"%");this.css.jq.currentTime.length&&this.css.jq.currentTime.text(b.jPlayer.convertTime(this.status.currentTime));this.css.jq.duration.length&&this.css.jq.duration.text(b.jPlayer.convertTime(this.status.duration))},_seeking:function(){this.css.jq.seekBar.length&&this.css.jq.seekBar.addClass("jp-seeking-bg")},_seeked:function(){this.css.jq.seekBar.length&&this.css.jq.seekBar.removeClass("jp-seeking-bg")},
_resetGate:function(){this.html.audio.gate=!1;this.html.video.gate=!1;this.flash.gate=!1},_resetActive:function(){this.html.active=!1;this.flash.active=!1},setMedia:function(a){var c=this,d=!1,e=this.status.media.poster!==a.poster;this._resetMedia();this._resetGate();this._resetActive();b.each(this.formats,function(e,f){var i=c.format[f].media==="video";b.each(c.solutions,function(b,e){if(c[e].support[f]&&c._validString(a[f])){var g=e==="html";i?(g?(c.html.video.gate=!0,c._html_setVideo(a),c.html.active=
!0):(c.flash.gate=!0,c._flash_setVideo(a),c.flash.active=!0),c.css.jq.videoPlay.length&&c.css.jq.videoPlay.show(),c.status.video=!0):(g?(c.html.audio.gate=!0,c._html_setAudio(a),c.html.active=!0):(c.flash.gate=!0,c._flash_setAudio(a),c.flash.active=!0),c.css.jq.videoPlay.length&&c.css.jq.videoPlay.hide(),c.status.video=!1);d=!0;return!1}});if(d)return!1});if(d){if((!this.status.nativeVideoControls||!this.html.video.gate)&&this._validString(a.poster))e?this.htmlElement.poster.src=a.poster:this.internal.poster.jq.show();
this.status.srcSet=!0;this.status.media=b.extend({},a);this._updateButtons(!1);this._updateInterface()}else this._error({type:b.jPlayer.error.NO_SUPPORT,context:"{supplied:'"+this.options.supplied+"'}",message:b.jPlayer.errorMsg.NO_SUPPORT,hint:b.jPlayer.errorHint.NO_SUPPORT})},_resetMedia:function(){this._resetStatus();this._updateButtons(!1);this._updateInterface();this._seeked();this.internal.poster.jq.hide();clearTimeout(this.internal.htmlDlyCmdId);this.html.active?this._html_resetMedia():this.flash.active&&
this._flash_resetMedia()},clearMedia:function(){this._resetMedia();this.html.active?this._html_clearMedia():this.flash.active&&this._flash_clearMedia();this._resetGate();this._resetActive()},load:function(){this.status.srcSet?this.html.active?this._html_load():this.flash.active&&this._flash_load():this._urlNotSetError("load")},play:function(a){a=typeof a==="number"?a:NaN;this.status.srcSet?this.html.active?this._html_play(a):this.flash.active&&this._flash_play(a):this._urlNotSetError("play")},videoPlay:function(){this.play()},
pause:function(a){a=typeof a==="number"?a:NaN;this.status.srcSet?this.html.active?this._html_pause(a):this.flash.active&&this._flash_pause(a):this._urlNotSetError("pause")},pauseOthers:function(){var a=this;b.each(this.instances,function(b,d){a.element!==d&&d.data("jPlayer").status.srcSet&&d.jPlayer("pause")})},stop:function(){this.status.srcSet?this.html.active?this._html_pause(0):this.flash.active&&this._flash_pause(0):this._urlNotSetError("stop")},playHead:function(a){a=this._limitValue(a,0,100);
this.status.srcSet?this.html.active?this._html_playHead(a):this.flash.active&&this._flash_playHead(a):this._urlNotSetError("playHead")},_muted:function(a){this.options.muted=a;this.html.used&&this._html_mute(a);this.flash.used&&this._flash_mute(a);!this.html.video.gate&&!this.html.audio.gate&&(this._updateMute(a),this._updateVolume(this.options.volume),this._trigger(b.jPlayer.event.volumechange))},mute:function(a){a=a===f?!0:!!a;this._muted(a)},unmute:function(a){a=a===f?!0:!!a;this._muted(!a)},_updateMute:function(a){if(a===
f)a=this.options.muted;this.css.jq.mute.length&&this.css.jq.unmute.length&&(this.status.noVolume?(this.css.jq.mute.hide(),this.css.jq.unmute.hide()):a?(this.css.jq.mute.hide(),this.css.jq.unmute.show()):(this.css.jq.mute.show(),this.css.jq.unmute.hide()))},volume:function(a){a=this._limitValue(a,0,1);this.options.volume=a;this.html.used&&this._html_volume(a);this.flash.used&&this._flash_volume(a);!this.html.video.gate&&!this.html.audio.gate&&(this._updateVolume(a),this._trigger(b.jPlayer.event.volumechange))},
volumeBar:function(a){if(this.css.jq.volumeBar.length){var b=this.css.jq.volumeBar.offset(),d=a.pageX-b.left,e=this.css.jq.volumeBar.width(),a=this.css.jq.volumeBar.height()-a.pageY+b.top,b=this.css.jq.volumeBar.height();this.options.verticalVolume?this.volume(a/b):this.volume(d/e)}this.options.muted&&this._muted(!1)},volumeBarValue:function(a){this.volumeBar(a)},_updateVolume:function(a){if(a===f)a=this.options.volume;a=this.options.muted?0:a;this.status.noVolume?(this.css.jq.volumeBar.length&&this.css.jq.volumeBar.hide(),
this.css.jq.volumeBarValue.length&&this.css.jq.volumeBarValue.hide(),this.css.jq.volumeMax.length&&this.css.jq.volumeMax.hide()):(this.css.jq.volumeBar.length&&this.css.jq.volumeBar.show(),this.css.jq.volumeBarValue.length&&(this.css.jq.volumeBarValue.show(),this.css.jq.volumeBarValue[this.options.verticalVolume?"height":"width"](a*100+"%")),this.css.jq.volumeMax.length&&this.css.jq.volumeMax.show())},volumeMax:function(){this.volume(1);this.options.muted&&this._muted(!1)},_cssSelectorAncestor:function(a){var c=
this;this.options.cssSelectorAncestor=a;this._removeUiClass();this.ancestorJq=a?b(a):[];a&&this.ancestorJq.length!==1&&this._warning({type:b.jPlayer.warning.CSS_SELECTOR_COUNT,context:a,message:b.jPlayer.warningMsg.CSS_SELECTOR_COUNT+this.ancestorJq.length+" found for cssSelectorAncestor.",hint:b.jPlayer.warningHint.CSS_SELECTOR_COUNT});this._addUiClass();b.each(this.options.cssSelector,function(a,b){c._cssSelector(a,b)})},_cssSelector:function(a,c){var d=this;typeof c==="string"?b.jPlayer.prototype.options.cssSelector[a]?
(this.css.jq[a]&&this.css.jq[a].length&&this.css.jq[a].unbind(".jPlayer"),this.options.cssSelector[a]=c,this.css.cs[a]=this.options.cssSelectorAncestor+" "+c,this.css.jq[a]=c?b(this.css.cs[a]):[],this.css.jq[a].length&&this.css.jq[a].bind("click.jPlayer",function(c){d[a](c);b(this).blur();return!1}),c&&this.css.jq[a].length!==1&&this._warning({type:b.jPlayer.warning.CSS_SELECTOR_COUNT,context:this.css.cs[a],message:b.jPlayer.warningMsg.CSS_SELECTOR_COUNT+this.css.jq[a].length+" found for "+a+" method.",
hint:b.jPlayer.warningHint.CSS_SELECTOR_COUNT})):this._warning({type:b.jPlayer.warning.CSS_SELECTOR_METHOD,context:a,message:b.jPlayer.warningMsg.CSS_SELECTOR_METHOD,hint:b.jPlayer.warningHint.CSS_SELECTOR_METHOD}):this._warning({type:b.jPlayer.warning.CSS_SELECTOR_STRING,context:c,message:b.jPlayer.warningMsg.CSS_SELECTOR_STRING,hint:b.jPlayer.warningHint.CSS_SELECTOR_STRING})},seekBar:function(a){if(this.css.jq.seekBar){var b=this.css.jq.seekBar.offset(),a=a.pageX-b.left,b=this.css.jq.seekBar.width();
this.playHead(100*a/b)}},playBar:function(a){this.seekBar(a)},repeat:function(){this._loop(!0)},repeatOff:function(){this._loop(!1)},_loop:function(a){if(this.options.loop!==a)this.options.loop=a,this._updateButtons(),this._trigger(b.jPlayer.event.repeat)},currentTime:function(){},duration:function(){},gui:function(){},noSolution:function(){},option:function(a,c){var d=a;if(arguments.length===0)return b.extend(!0,{},this.options);if(typeof a==="string"){var e=a.split(".");if(c===f){for(var d=b.extend(!0,
{},this.options),g=0;g<e.length;g++)if(d[e[g]]!==f)d=d[e[g]];else return this._warning({type:b.jPlayer.warning.OPTION_KEY,context:a,message:b.jPlayer.warningMsg.OPTION_KEY,hint:b.jPlayer.warningHint.OPTION_KEY}),f;return d}for(var g=d={},h=0;h<e.length;h++)h<e.length-1?(g[e[h]]={},g=g[e[h]]):g[e[h]]=c}this._setOptions(d);return this},_setOptions:function(a){var c=this;b.each(a,function(a,b){c._setOption(a,b)});return this},_setOption:function(a,c){var d=this;switch(a){case "volume":this.volume(c);
break;case "muted":this._muted(c);break;case "cssSelectorAncestor":this._cssSelectorAncestor(c);break;case "cssSelector":b.each(c,function(a,b){d._cssSelector(a,b)});break;case "fullScreen":this.options[a]!==c&&(this._removeUiClass(),this.options[a]=c,this._refreshSize());break;case "size":!this.options.fullScreen&&this.options[a].cssClass!==c.cssClass&&this._removeUiClass();this.options[a]=b.extend({},this.options[a],c);this._refreshSize();break;case "sizeFull":this.options.fullScreen&&this.options[a].cssClass!==
c.cssClass&&this._removeUiClass();this.options[a]=b.extend({},this.options[a],c);this._refreshSize();break;case "autohide":this.options[a]=b.extend({},this.options[a],c);this._updateAutohide();break;case "loop":this._loop(c);break;case "nativeVideoControls":this.options[a]=b.extend({},this.options[a],c);this.status.nativeVideoControls=this._uaBlocklist(this.options.nativeVideoControls);this._restrictNativeVideoControls();this._updateNativeVideoControls();break;case "noFullScreen":this.options[a]=
b.extend({},this.options[a],c);this.status.nativeVideoControls=this._uaBlocklist(this.options.nativeVideoControls);this.status.noFullScreen=this._uaBlocklist(this.options.noFullScreen);this._restrictNativeVideoControls();this._updateButtons();break;case "noVolume":this.options[a]=b.extend({},this.options[a],c);this.status.noVolume=this._uaBlocklist(this.options.noVolume);this._updateVolume();this._updateMute();break;case "emulateHtml":this.options[a]!==c&&((this.options[a]=c)?this._emulateHtmlBridge():
this._destroyHtmlBridge())}return this},_refreshSize:function(){this._setSize();this._addUiClass();this._updateSize();this._updateButtons();this._updateAutohide();this._trigger(b.jPlayer.event.resize)},_setSize:function(){this.options.fullScreen?(this.status.width=this.options.sizeFull.width,this.status.height=this.options.sizeFull.height,this.status.cssClass=this.options.sizeFull.cssClass):(this.status.width=this.options.size.width,this.status.height=this.options.size.height,this.status.cssClass=
this.options.size.cssClass);this.element.css({width:this.status.width,height:this.status.height})},_addUiClass:function(){this.ancestorJq.length&&this.ancestorJq.addClass(this.status.cssClass)},_removeUiClass:function(){this.ancestorJq.length&&this.ancestorJq.removeClass(this.status.cssClass)},_updateSize:function(){this.internal.poster.jq.css({width:this.status.width,height:this.status.height});!this.status.waitForPlay&&this.html.active&&this.status.video||this.html.video.available&&this.html.used&&
this.status.nativeVideoControls?this.internal.video.jq.css({width:this.status.width,height:this.status.height}):!this.status.waitForPlay&&this.flash.active&&this.status.video&&this.internal.flash.jq.css({width:this.status.width,height:this.status.height})},_updateAutohide:function(){var a=this,b=function(){a.css.jq.gui.fadeIn(a.options.autohide.fadeIn,function(){clearTimeout(a.internal.autohideId);a.internal.autohideId=setTimeout(function(){a.css.jq.gui.fadeOut(a.options.autohide.fadeOut)},a.options.autohide.hold)})};
this.css.jq.gui.length&&(this.css.jq.gui.stop(!0,!0),clearTimeout(this.internal.autohideId),this.element.unbind(".jPlayerAutohide"),this.css.jq.gui.unbind(".jPlayerAutohide"),this.status.nativeVideoControls?this.css.jq.gui.hide():this.options.fullScreen&&this.options.autohide.full||!this.options.fullScreen&&this.options.autohide.restored?(this.element.bind("mousemove.jPlayer.jPlayerAutohide",b),this.css.jq.gui.bind("mousemove.jPlayer.jPlayerAutohide",b),this.css.jq.gui.hide()):this.css.jq.gui.show())},
fullScreen:function(){this._setOption("fullScreen",!0)},restoreScreen:function(){this._setOption("fullScreen",!1)},_html_initMedia:function(){this.htmlElement.media.src=this.status.src;this.options.preload!=="none"&&this._html_load();this._trigger(b.jPlayer.event.timeupdate)},_html_setAudio:function(a){var c=this;b.each(this.formats,function(b,e){if(c.html.support[e]&&a[e])return c.status.src=a[e],c.status.format[e]=!0,c.status.formatType=e,!1});this.htmlElement.media=this.htmlElement.audio;this._html_initMedia()},
_html_setVideo:function(a){var c=this;b.each(this.formats,function(b,e){if(c.html.support[e]&&a[e])return c.status.src=a[e],c.status.format[e]=!0,c.status.formatType=e,!1});if(this.status.nativeVideoControls)this.htmlElement.video.poster=this._validString(a.poster)?a.poster:"";this.htmlElement.media=this.htmlElement.video;this._html_initMedia()},_html_resetMedia:function(){this.htmlElement.media&&(this.htmlElement.media.id===this.internal.video.id&&!this.status.nativeVideoControls&&this.internal.video.jq.css({width:"0px",
height:"0px"}),this.htmlElement.media.pause())},_html_clearMedia:function(){if(this.htmlElement.media)this.htmlElement.media.src="",this.htmlElement.media.load()},_html_load:function(){if(this.status.waitForLoad)this.status.waitForLoad=!1,this.htmlElement.media.load();clearTimeout(this.internal.htmlDlyCmdId)},_html_play:function(a){var b=this;this._html_load();this.htmlElement.media.play();if(!isNaN(a))try{this.htmlElement.media.currentTime=a}catch(d){this.internal.htmlDlyCmdId=setTimeout(function(){b.play(a)},
100);return}this._html_checkWaitForPlay()},_html_pause:function(a){var b=this;a>0?this._html_load():clearTimeout(this.internal.htmlDlyCmdId);this.htmlElement.media.pause();if(!isNaN(a))try{this.htmlElement.media.currentTime=a}catch(d){this.internal.htmlDlyCmdId=setTimeout(function(){b.pause(a)},100);return}a>0&&this._html_checkWaitForPlay()},_html_playHead:function(a){var b=this;this._html_load();try{if(typeof this.htmlElement.media.seekable==="object"&&this.htmlElement.media.seekable.length>0)this.htmlElement.media.currentTime=
a*this.htmlElement.media.seekable.end(this.htmlElement.media.seekable.length-1)/100;else if(this.htmlElement.media.duration>0&&!isNaN(this.htmlElement.media.duration))this.htmlElement.media.currentTime=a*this.htmlElement.media.duration/100;else throw"e";}catch(d){this.internal.htmlDlyCmdId=setTimeout(function(){b.playHead(a)},100);return}this.status.waitForLoad||this._html_checkWaitForPlay()},_html_checkWaitForPlay:function(){if(this.status.waitForPlay)this.status.waitForPlay=!1,this.css.jq.videoPlay.length&&
this.css.jq.videoPlay.hide(),this.status.video&&(this.internal.poster.jq.hide(),this.internal.video.jq.css({width:this.status.width,height:this.status.height}))},_html_volume:function(a){if(this.html.audio.available)this.htmlElement.audio.volume=a;if(this.html.video.available)this.htmlElement.video.volume=a},_html_mute:function(a){if(this.html.audio.available)this.htmlElement.audio.muted=a;if(this.html.video.available)this.htmlElement.video.muted=a},_flash_setAudio:function(a){var c=this;try{if(b.each(this.formats,
function(b,d){if(c.flash.support[d]&&a[d]){switch(d){case "m4a":case "fla":c._getMovie().fl_setAudio_m4a(a[d]);break;case "mp3":c._getMovie().fl_setAudio_mp3(a[d])}c.status.src=a[d];c.status.format[d]=!0;c.status.formatType=d;return!1}}),this.options.preload==="auto")this._flash_load(),this.status.waitForLoad=!1}catch(d){this._flashError(d)}},_flash_setVideo:function(a){var c=this;try{if(b.each(this.formats,function(b,d){if(c.flash.support[d]&&a[d]){switch(d){case "m4v":case "flv":c._getMovie().fl_setVideo_m4v(a[d])}c.status.src=
a[d];c.status.format[d]=!0;c.status.formatType=d;return!1}}),this.options.preload==="auto")this._flash_load(),this.status.waitForLoad=!1}catch(d){this._flashError(d)}},_flash_resetMedia:function(){this.internal.flash.jq.css({width:"0px",height:"0px"});this._flash_pause(NaN)},_flash_clearMedia:function(){try{this._getMovie().fl_clearMedia()}catch(a){this._flashError(a)}},_flash_load:function(){try{this._getMovie().fl_load()}catch(a){this._flashError(a)}this.status.waitForLoad=!1},_flash_play:function(a){try{this._getMovie().fl_play(a)}catch(b){this._flashError(b)}this.status.waitForLoad=
!1;this._flash_checkWaitForPlay()},_flash_pause:function(a){try{this._getMovie().fl_pause(a)}catch(b){this._flashError(b)}if(a>0)this.status.waitForLoad=!1,this._flash_checkWaitForPlay()},_flash_playHead:function(a){try{this._getMovie().fl_play_head(a)}catch(b){this._flashError(b)}this.status.waitForLoad||this._flash_checkWaitForPlay()},_flash_checkWaitForPlay:function(){if(this.status.waitForPlay)this.status.waitForPlay=!1,this.css.jq.videoPlay.length&&this.css.jq.videoPlay.hide(),this.status.video&&
(this.internal.poster.jq.hide(),this.internal.flash.jq.css({width:this.status.width,height:this.status.height}))},_flash_volume:function(a){try{this._getMovie().fl_volume(a)}catch(b){this._flashError(b)}},_flash_mute:function(a){try{this._getMovie().fl_mute(a)}catch(b){this._flashError(b)}},_getMovie:function(){return document[this.internal.flash.id]},_checkForFlash:function(a){var b=!1,d;if(window.ActiveXObject)try{new ActiveXObject("ShockwaveFlash.ShockwaveFlash."+a),b=!0}catch(e){}else navigator.plugins&&
navigator.mimeTypes.length>0&&(d=navigator.plugins["Shockwave Flash"])&&navigator.plugins["Shockwave Flash"].description.replace(/.*\s(\d+\.\d+).*/,"$1")>=a&&(b=!0);return b},_validString:function(a){return a&&typeof a==="string"},_limitValue:function(a,b,d){return a<b?b:a>d?d:a},_urlNotSetError:function(a){this._error({type:b.jPlayer.error.URL_NOT_SET,context:a,message:b.jPlayer.errorMsg.URL_NOT_SET,hint:b.jPlayer.errorHint.URL_NOT_SET})},_flashError:function(a){var c;c=this.internal.ready?"FLASH_DISABLED":
"FLASH";this._error({type:b.jPlayer.error[c],context:this.internal.flash.swf,message:b.jPlayer.errorMsg[c]+a.message,hint:b.jPlayer.errorHint[c]});this.internal.flash.jq.css({width:"1px",height:"1px"})},_error:function(a){this._trigger(b.jPlayer.event.error,a);this.options.errorAlerts&&this._alert("Error!"+(a.message?"\n\n"+a.message:"")+(a.hint?"\n\n"+a.hint:"")+"\n\nContext: "+a.context)},_warning:function(a){this._trigger(b.jPlayer.event.warning,f,a);this.options.warningAlerts&&this._alert("Warning!"+
(a.message?"\n\n"+a.message:"")+(a.hint?"\n\n"+a.hint:"")+"\n\nContext: "+a.context)},_alert:function(a){alert("jPlayer "+this.version.script+" : id='"+this.internal.self.id+"' : "+a)},_emulateHtmlBridge:function(){var a=this;b.each(b.jPlayer.emulateMethods.split(/\s+/g),function(b,d){a.internal.domNode[d]=function(b){a[d](b)}});b.each(b.jPlayer.event,function(c,d){var e=!0;b.each(b.jPlayer.reservedEvent.split(/\s+/g),function(a,b){if(b===c)return e=!1});e&&a.element.bind(d+".jPlayer.jPlayerHtml",
function(){a._emulateHtmlUpdate();var b=document.createEvent("Event");b.initEvent(c,!1,!0);a.internal.domNode.dispatchEvent(b)})})},_emulateHtmlUpdate:function(){var a=this;b.each(b.jPlayer.emulateStatus.split(/\s+/g),function(b,d){a.internal.domNode[d]=a.status[d]});b.each(b.jPlayer.emulateOptions.split(/\s+/g),function(b,d){a.internal.domNode[d]=a.options[d]})},_destroyHtmlBridge:function(){var a=this;this.element.unbind(".jPlayerHtml");b.each((b.jPlayer.emulateMethods+" "+b.jPlayer.emulateStatus+
" "+b.jPlayer.emulateOptions).split(/\s+/g),function(b,d){delete a.internal.domNode[d]})}};b.jPlayer.error={FLASH:"e_flash",FLASH_DISABLED:"e_flash_disabled",NO_SOLUTION:"e_no_solution",NO_SUPPORT:"e_no_support",URL:"e_url",URL_NOT_SET:"e_url_not_set",VERSION:"e_version"};b.jPlayer.errorMsg={FLASH:"jPlayer's Flash fallback is not configured correctly, or a command was issued before the jPlayer Ready event. Details: ",FLASH_DISABLED:"jPlayer's Flash fallback has been disabled by the browser due to the CSS rules you have used. Details: ",
NO_SOLUTION:"No solution can be found by jPlayer in this browser. Neither HTML nor Flash can be used.",NO_SUPPORT:"It is not possible to play any media format provided in setMedia() on this browser using your current options.",URL:"Media URL could not be loaded.",URL_NOT_SET:"Attempt to issue media playback commands, while no media url is set.",VERSION:"jPlayer "+b.jPlayer.prototype.version.script+" needs Jplayer.swf version "+b.jPlayer.prototype.version.needFlash+" but found "};b.jPlayer.errorHint=
{FLASH:"Check your swfPath option and that Jplayer.swf is there.",FLASH_DISABLED:"Check that you have not display:none; the jPlayer entity or any ancestor.",NO_SOLUTION:"Review the jPlayer options: support and supplied.",NO_SUPPORT:"Video or audio formats defined in the supplied option are missing.",URL:"Check media URL is valid.",URL_NOT_SET:"Use setMedia() to set the media URL.",VERSION:"Update jPlayer files."};b.jPlayer.warning={CSS_SELECTOR_COUNT:"e_css_selector_count",CSS_SELECTOR_METHOD:"e_css_selector_method",
CSS_SELECTOR_STRING:"e_css_selector_string",OPTION_KEY:"e_option_key"};b.jPlayer.warningMsg={CSS_SELECTOR_COUNT:"The number of css selectors found did not equal one: ",CSS_SELECTOR_METHOD:"The methodName given in jPlayer('cssSelector') is not a valid jPlayer method.",CSS_SELECTOR_STRING:"The methodCssSelector given in jPlayer('cssSelector') is not a String or is empty.",OPTION_KEY:"The option requested in jPlayer('option') is undefined."};b.jPlayer.warningHint={CSS_SELECTOR_COUNT:"Check your css selector and the ancestor.",
CSS_SELECTOR_METHOD:"Check your method name.",CSS_SELECTOR_STRING:"Check your css selector is a string.",OPTION_KEY:"Check your option name."}})(jQuery);


/*
 * Playlist Object for the jPlayer Plugin
 * http://www.jplayer.org
 *
 * Copyright (c) 2009 - 2011 Happyworm Ltd
 * Dual licensed under the MIT and GPL licenses.
 *  - http://www.opensource.org/licenses/mit-license.php
 *  - http://www.gnu.org/copyleft/gpl.html
 *
 * Author: Mark J Panaghiston
 * Version: 2.1.0 (jPlayer 2.1.0)
 * Date: 1st September 2011
 */

(function(b,f){jPlayerPlaylist=function(a,c,d){var e=this;this.current=0;this.removing=this.shuffled=this.loop=!1;this.cssSelector=b.extend({},this._cssSelector,a);this.options=b.extend(!0,{},this._options,d);this.playlist=[];this.original=[];this._initPlaylist(c);this.cssSelector.title=this.cssSelector.cssSelectorAncestor+" .jp-title";this.cssSelector.playlist=this.cssSelector.cssSelectorAncestor+" .jp-playlist";this.cssSelector.next=this.cssSelector.cssSelectorAncestor+" .jp-next";this.cssSelector.previous=
this.cssSelector.cssSelectorAncestor+" .jp-previous";this.cssSelector.shuffle=this.cssSelector.cssSelectorAncestor+" .jp-shuffle";this.cssSelector.shuffleOff=this.cssSelector.cssSelectorAncestor+" .jp-shuffle-off";this.options.cssSelectorAncestor=this.cssSelector.cssSelectorAncestor;this.options.repeat=function(a){e.loop=a.jPlayer.options.loop};b(this.cssSelector.jPlayer).bind(b.jPlayer.event.ready,function(){e._init()});b(this.cssSelector.jPlayer).bind(b.jPlayer.event.ended,function(){e.next()});
b(this.cssSelector.jPlayer).bind(b.jPlayer.event.play,function(){b(this).jPlayer("pauseOthers")});b(this.cssSelector.jPlayer).bind(b.jPlayer.event.resize,function(a){a.jPlayer.options.fullScreen?b(e.cssSelector.title).show():b(e.cssSelector.title).hide()});b(this.cssSelector.previous).click(function(){e.previous();b(this).blur();return!1});b(this.cssSelector.next).click(function(){e.next();b(this).blur();return!1});b(this.cssSelector.shuffle).click(function(){e.shuffle(!0);return!1});b(this.cssSelector.shuffleOff).click(function(){e.shuffle(!1);
return!1}).hide();this.options.fullScreen||b(this.cssSelector.title).hide();b(this.cssSelector.playlist+" ul").empty();this._createItemHandlers();b(this.cssSelector.jPlayer).jPlayer(this.options)};jPlayerPlaylist.prototype={_cssSelector:{jPlayer:"#jquery_jplayer_1",cssSelectorAncestor:"#jp_container_1"},_options:{playlistOptions:{autoPlay:!1,loopOnPrevious:!1,shuffleOnLoop:!0,enableRemoveControls:!1,displayTime:"slow",addTime:"fast",removeTime:"fast",shuffleTime:"slow",itemClass:"jp-playlist-item",
freeGroupClass:"jp-free-media",freeItemClass:"jp-playlist-item-free",removeItemClass:"jp-playlist-item-remove"}},option:function(a,b){if(b===f)return this.options.playlistOptions[a];this.options.playlistOptions[a]=b;switch(a){case "enableRemoveControls":this._updateControls();break;case "itemClass":case "freeGroupClass":case "freeItemClass":case "removeItemClass":this._refresh(!0),this._createItemHandlers()}return this},_init:function(){var a=this;this._refresh(function(){a.options.playlistOptions.autoPlay?
a.play(a.current):a.select(a.current)})},_initPlaylist:function(a){this.current=0;this.removing=this.shuffled=!1;this.original=b.extend(!0,[],a);this._originalPlaylist()},_originalPlaylist:function(){var a=this;this.playlist=[];b.each(this.original,function(b){a.playlist[b]=a.original[b]})},_refresh:function(a){var c=this;if(a&&!b.isFunction(a))b(this.cssSelector.playlist+" ul").empty(),b.each(this.playlist,function(a){b(c.cssSelector.playlist+" ul").append(c._createListItem(c.playlist[a]))}),this._updateControls();
else{var d=b(this.cssSelector.playlist+" ul").children().length?this.options.playlistOptions.displayTime:0;b(this.cssSelector.playlist+" ul").slideUp(d,function(){var d=b(this);b(this).empty();b.each(c.playlist,function(a){d.append(c._createListItem(c.playlist[a]))});c._updateControls();b.isFunction(a)&&a();c.playlist.length?b(this).slideDown(c.options.playlistOptions.displayTime):b(this).show()})}},_createListItem:function(a){var c=this,d="<li><div>";d+="<a href='javascript:;' class='"+this.options.playlistOptions.removeItemClass+
"'>&times;</a>";if(a.free){var e=!0;d+="<span class='"+this.options.playlistOptions.freeGroupClass+"'>(";b.each(a,function(a,f){b.jPlayer.prototype.format[a]&&(e?e=!1:d+=" | ",d+="<a class='"+c.options.playlistOptions.freeItemClass+"' href='"+f+"' tabindex='1'>"+a+"</a>")});d+=")</span>"}d+="<a href='javascript:;' class='"+this.options.playlistOptions.itemClass+"' tabindex='1'>"+a.title+(a.artist?" <span class='jp-artist'>by "+a.artist+"</span>":"")+"</a>";d+="</div></li>";return d},_createItemHandlers:function(){var a=
this;b(this.cssSelector.playlist+" a."+this.options.playlistOptions.itemClass).die("click").live("click",function(){var c=b(this).parent().parent().index();a.current!==c?a.play(c):b(a.cssSelector.jPlayer).jPlayer("play");b(this).blur();return!1});b(a.cssSelector.playlist+" a."+this.options.playlistOptions.freeItemClass).die("click").live("click",function(){b(this).parent().parent().find("."+a.options.playlistOptions.itemClass).click();b(this).blur();return!1});b(a.cssSelector.playlist+" a."+this.options.playlistOptions.removeItemClass).die("click").live("click",
function(){var c=b(this).parent().parent().index();a.remove(c);b(this).blur();return!1})},_updateControls:function(){this.options.playlistOptions.enableRemoveControls?b(this.cssSelector.playlist+" ."+this.options.playlistOptions.removeItemClass).show():b(this.cssSelector.playlist+" ."+this.options.playlistOptions.removeItemClass).hide();this.shuffled?(b(this.cssSelector.shuffleOff).show(),b(this.cssSelector.shuffle).hide()):(b(this.cssSelector.shuffleOff).hide(),b(this.cssSelector.shuffle).show())},
_highlight:function(a){this.playlist.length&&a!==f&&(b(this.cssSelector.playlist+" .jp-playlist-current").removeClass("jp-playlist-current"),b(this.cssSelector.playlist+" li:nth-child("+(a+1)+")").addClass("jp-playlist-current").find(".jp-playlist-item").addClass("jp-playlist-current"),b(this.cssSelector.title+" li").html(this.playlist[a].title+(this.playlist[a].artist?" <span class='jp-artist'>by "+this.playlist[a].artist+"</span>":"")))},setPlaylist:function(a){this._initPlaylist(a);this._init()},
add:function(a,c){b(this.cssSelector.playlist+" ul").append(this._createListItem(a)).find("li:last-child").hide().slideDown(this.options.playlistOptions.addTime);this._updateControls();this.original.push(a);this.playlist.push(a);c?this.play(this.playlist.length-1):this.original.length===1&&this.select(0)},remove:function(a){var c=this;if(a===f)return this._initPlaylist([]),this._refresh(function(){b(c.cssSelector.jPlayer).jPlayer("clearMedia")}),!0;else if(this.removing)return!1;else{a=a<0?c.original.length+
a:a;if(0<=a&&a<this.playlist.length)this.removing=!0,b(this.cssSelector.playlist+" li:nth-child("+(a+1)+")").slideUp(this.options.playlistOptions.removeTime,function(){b(this).remove();if(c.shuffled){var d=c.playlist[a];b.each(c.original,function(a){if(c.original[a]===d)return c.original.splice(a,1),!1})}else c.original.splice(a,1);c.playlist.splice(a,1);c.original.length?a===c.current?(c.current=a<c.original.length?c.current:c.original.length-1,c.select(c.current)):a<c.current&&c.current--:(b(c.cssSelector.jPlayer).jPlayer("clearMedia"),
c.current=0,c.shuffled=!1,c._updateControls());c.removing=!1});return!0}},select:function(a){a=a<0?this.original.length+a:a;0<=a&&a<this.playlist.length?(this.current=a,this._highlight(a),b(this.cssSelector.jPlayer).jPlayer("setMedia",this.playlist[this.current])):this.current=0},play:function(a){a=a<0?this.original.length+a:a;0<=a&&a<this.playlist.length?this.playlist.length&&(this.select(a),b(this.cssSelector.jPlayer).jPlayer("play")):a===f&&b(this.cssSelector.jPlayer).jPlayer("play")},pause:function(){b(this.cssSelector.jPlayer).jPlayer("pause")},
next:function(){var a=this.current+1<this.playlist.length?this.current+1:0;this.loop?a===0&&this.shuffled&&this.options.playlistOptions.shuffleOnLoop&&this.playlist.length>1?this.shuffle(!0,!0):this.play(a):a>0&&this.play(a)/*$(this).trigger("playlist_ended")*/},previous:function(){var a=this.current-1>=0?this.current-1:this.playlist.length-1;(this.loop&&this.options.playlistOptions.loopOnPrevious||a<this.playlist.length-1)&&this.play(a)},shuffle:function(a,c){var d=this;a===f&&(a=!this.shuffled);(a||a!==this.shuffled)&&b(this.cssSelector.playlist+
" ul").slideUp(this.options.playlistOptions.shuffleTime,function(){(d.shuffled=a)?d.playlist.sort(function(){return 0.5-Math.random()}):d._originalPlaylist();d._refresh(!0);c||!b(d.cssSelector.jPlayer).data("jPlayer").status.paused?d.play(0):d.select(0);b(this).slideDown(d.options.playlistOptions.shuffleTime)})}}})(jQuery);


/**
 * FitVids 1.0
 *
 * Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 *
 * Date: Thu Sept 01 18:00:00 2011 -0500
 */
(function($){$.fn.fitVids=function(options){var settings={customSelector:null}
var div=document.createElement('div'),ref=document.getElementsByTagName('base')[0]||document.getElementsByTagName('script')[0];div.className='fit-vids-style';div.innerHTML='&shy;<style>         \
      .fluid-width-video-wrapper {        \
         width: 100%;                     \
         position: relative;              \
         padding: 0;                      \
      }                                   \
                                          \
      .fluid-width-video-wrapper iframe,  \
      .fluid-width-video-wrapper object,  \
      .fluid-width-video-wrapper embed {  \
         position: absolute;              \
         top: 0;                          \
         left: 0;                         \
         width: 100%;                     \
         height: 100%;                    \
      }                                   \
    </style>';ref.parentNode.insertBefore(div,ref);if(options){$.extend(settings,options);}
return this.each(function(){var selectors=["iframe[src^='http://player.vimeo.com']","iframe[src^='http://www.youtube.com']","iframe[src^='https://www.youtube.com']","iframe[src^='http://www.kickstarter.com']","object","embed"];if(settings.customSelector){selectors.push(settings.customSelector);}
var $allVideos=$(this).find(selectors.join(','));$allVideos.each(function(){var $this=$(this);if(this.tagName.toLowerCase()=='embed'&&$this.parent('object').length||$this.parent('.fluid-width-video-wrapper').length){return;}
var height=this.tagName.toLowerCase()=='object'?$this.attr('height'):$this.height(),aspectRatio=height/$this.width();if(!$this.attr('id')){var videoID='fitvid'+Math.floor(Math.random()*999999);$this.attr('id',videoID);}
$this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top',(aspectRatio*100)+"%");$this.removeAttr('height').removeAttr('width');});});}})(jQuery);


/*!
 * jCarousel - Riding carousels with jQuery
 *   http://sorgalla.com/jcarousel/
 *
 * Copyright (c) 2006 Jan Sorgalla (http://sorgalla.com)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Built on top of the jQuery library
 *   http://jquery.com
 *
 * Inspired by the "Carousel Component" by Bill Scott
 *   http://billwscott.com/carousel/
 */

(function(g){var q={vertical:!1,rtl:!1,start:1,offset:1,size:null,scroll:3,visible:null,animation:"normal",easing:"swing",auto:0,wrap:null,initCallback:null,setupCallback:null,reloadCallback:null,itemLoadCallback:null,itemFirstInCallback:null,itemFirstOutCallback:null,itemLastInCallback:null,itemLastOutCallback:null,itemVisibleInCallback:null,itemVisibleOutCallback:null,animationStepCallback:null,buttonNextHTML:"<div></div>",buttonPrevHTML:"<div></div>",buttonNextEvent:"click",buttonPrevEvent:"click", buttonNextCallback:null,buttonPrevCallback:null,itemFallbackDimension:null},m=!1;g(window).bind("load.jcarousel",function(){m=!0});g.jcarousel=function(a,c){this.options=g.extend({},q,c||{});this.autoStopped=this.locked=!1;this.buttonPrevState=this.buttonNextState=this.buttonPrev=this.buttonNext=this.list=this.clip=this.container=null;if(!c||c.rtl===void 0)this.options.rtl=(g(a).attr("dir")||g("html").attr("dir")||"").toLowerCase()=="rtl";this.wh=!this.options.vertical?"width":"height";this.lt=!this.options.vertical? this.options.rtl?"right":"left":"top";for(var b="",d=a.className.split(" "),f=0;f<d.length;f++)if(d[f].indexOf("jcarousel-skin")!=-1){g(a).removeClass(d[f]);b=d[f];break}a.nodeName.toUpperCase()=="UL"||a.nodeName.toUpperCase()=="OL"?(this.list=g(a),this.clip=this.list.parents(".jcarousel-clip"),this.container=this.list.parents(".jcarousel-container")):(this.container=g(a),this.list=this.container.find("ul,ol").eq(0),this.clip=this.container.find(".jcarousel-clip"));if(this.clip.size()===0)this.clip= this.list.wrap("<div></div>").parent();if(this.container.size()===0)this.container=this.clip.wrap("<div></div>").parent();b!==""&&this.container.parent()[0].className.indexOf("jcarousel-skin")==-1&&this.container.wrap('<div class=" '+b+'"></div>');this.buttonPrev=g(".jcarousel-prev",this.container);if(this.buttonPrev.size()===0&&this.options.buttonPrevHTML!==null)this.buttonPrev=g(this.options.buttonPrevHTML).appendTo(this.container);this.buttonPrev.addClass(this.className("jcarousel-prev"));this.buttonNext= g(".jcarousel-next",this.container);if(this.buttonNext.size()===0&&this.options.buttonNextHTML!==null)this.buttonNext=g(this.options.buttonNextHTML).appendTo(this.container);this.buttonNext.addClass(this.className("jcarousel-next"));this.clip.addClass(this.className("jcarousel-clip")).css({position:"relative"});this.list.addClass(this.className("jcarousel-list")).css({overflow:"hidden",position:"relative",top:0,margin:0,padding:0}).css(this.options.rtl?"right":"left",0);this.container.addClass(this.className("jcarousel-container")).css({position:"relative"}); !this.options.vertical&&this.options.rtl&&this.container.addClass("jcarousel-direction-rtl").attr("dir","rtl");var j=this.options.visible!==null?Math.ceil(this.clipping()/this.options.visible):null,b=this.list.children("li"),e=this;if(b.size()>0){var h=0,i=this.options.offset;b.each(function(){e.format(this,i++);h+=e.dimension(this,j)});this.list.css(this.wh,h+100+"px");if(!c||c.size===void 0)this.options.size=b.size()}this.container.css("display","block");this.buttonNext.css("display","block");this.buttonPrev.css("display", "block");this.funcNext=function(){e.next()};this.funcPrev=function(){e.prev()};this.funcResize=function(){e.resizeTimer&&clearTimeout(e.resizeTimer);e.resizeTimer=setTimeout(function(){e.reload()},100)};this.options.initCallback!==null&&this.options.initCallback(this,"init");!m&&g.browser.safari?(this.buttons(!1,!1),g(window).bind("load.jcarousel",function(){e.setup()})):this.setup()};var f=g.jcarousel;f.fn=f.prototype={jcarousel:"0.2.8"};f.fn.extend=f.extend=g.extend;f.fn.extend({setup:function(){this.prevLast= this.prevFirst=this.last=this.first=null;this.animating=!1;this.tail=this.resizeTimer=this.timer=null;this.inTail=!1;if(!this.locked){this.list.css(this.lt,this.pos(this.options.offset)+"px");var a=this.pos(this.options.start,!0);this.prevFirst=this.prevLast=null;this.animate(a,!1);g(window).unbind("resize.jcarousel",this.funcResize).bind("resize.jcarousel",this.funcResize);this.options.setupCallback!==null&&this.options.setupCallback(this)}},reset:function(){this.list.empty();this.list.css(this.lt, "0px");this.list.css(this.wh,"10px");this.options.initCallback!==null&&this.options.initCallback(this,"reset");this.setup()},reload:function(){this.tail!==null&&this.inTail&&this.list.css(this.lt,f.intval(this.list.css(this.lt))+this.tail);this.tail=null;this.inTail=!1;this.options.reloadCallback!==null&&this.options.reloadCallback(this);if(this.options.visible!==null){var a=this,c=Math.ceil(this.clipping()/this.options.visible),b=0,d=0;this.list.children("li").each(function(f){b+=a.dimension(this, c);f+1<a.first&&(d=b)});this.list.css(this.wh,b+"px");this.list.css(this.lt,-d+"px")}this.scroll(this.first,!1)},lock:function(){this.locked=!0;this.buttons()},unlock:function(){this.locked=!1;this.buttons()},size:function(a){if(a!==void 0)this.options.size=a,this.locked||this.buttons();return this.options.size},has:function(a,c){if(c===void 0||!c)c=a;if(this.options.size!==null&&c>this.options.size)c=this.options.size;for(var b=a;b<=c;b++){var d=this.get(b);if(!d.length||d.hasClass("jcarousel-item-placeholder"))return!1}return!0}, get:function(a){return g(">.jcarousel-item-"+a,this.list)},add:function(a,c){var b=this.get(a),d=0,p=g(c);if(b.length===0)for(var j,e=f.intval(a),b=this.create(a);;){if(j=this.get(--e),e<=0||j.length){e<=0?this.list.prepend(b):j.after(b);break}}else d=this.dimension(b);p.get(0).nodeName.toUpperCase()=="LI"?(b.replaceWith(p),b=p):b.empty().append(c);this.format(b.removeClass(this.className("jcarousel-item-placeholder")),a);p=this.options.visible!==null?Math.ceil(this.clipping()/this.options.visible): null;d=this.dimension(b,p)-d;a>0&&a<this.first&&this.list.css(this.lt,f.intval(this.list.css(this.lt))-d+"px");this.list.css(this.wh,f.intval(this.list.css(this.wh))+d+"px");return b},remove:function(a){var c=this.get(a);if(c.length&&!(a>=this.first&&a<=this.last)){var b=this.dimension(c);a<this.first&&this.list.css(this.lt,f.intval(this.list.css(this.lt))+b+"px");c.remove();this.list.css(this.wh,f.intval(this.list.css(this.wh))-b+"px")}},next:function(){this.tail!==null&&!this.inTail?this.scrollTail(!1): this.scroll((this.options.wrap=="both"||this.options.wrap=="last")&&this.options.size!==null&&this.last==this.options.size?1:this.first+this.options.scroll)},prev:function(){this.tail!==null&&this.inTail?this.scrollTail(!0):this.scroll((this.options.wrap=="both"||this.options.wrap=="first")&&this.options.size!==null&&this.first==1?this.options.size:this.first-this.options.scroll)},scrollTail:function(a){if(!this.locked&&!this.animating&&this.tail){this.pauseAuto();var c=f.intval(this.list.css(this.lt)), c=!a?c-this.tail:c+this.tail;this.inTail=!a;this.prevFirst=this.first;this.prevLast=this.last;this.animate(c)}},scroll:function(a,c){!this.locked&&!this.animating&&(this.pauseAuto(),this.animate(this.pos(a),c))},pos:function(a,c){var b=f.intval(this.list.css(this.lt));if(this.locked||this.animating)return b;this.options.wrap!="circular"&&(a=a<1?1:this.options.size&&a>this.options.size?this.options.size:a);for(var d=this.first>a,g=this.options.wrap!="circular"&&this.first<=1?1:this.first,j=d?this.get(g): this.get(this.last),e=d?g:g-1,h=null,i=0,k=!1,l=0;d?--e>=a:++e<a;){h=this.get(e);k=!h.length;if(h.length===0&&(h=this.create(e).addClass(this.className("jcarousel-item-placeholder")),j[d?"before":"after"](h),this.first!==null&&this.options.wrap=="circular"&&this.options.size!==null&&(e<=0||e>this.options.size)))j=this.get(this.index(e)),j.length&&(h=this.add(e,j.clone(!0)));j=h;l=this.dimension(h);k&&(i+=l);if(this.first!==null&&(this.options.wrap=="circular"||e>=1&&(this.options.size===null||e<= this.options.size)))b=d?b+l:b-l}for(var g=this.clipping(),m=[],o=0,n=0,j=this.get(a-1),e=a;++o;){h=this.get(e);k=!h.length;if(h.length===0){h=this.create(e).addClass(this.className("jcarousel-item-placeholder"));if(j.length===0)this.list.prepend(h);else j[d?"before":"after"](h);if(this.first!==null&&this.options.wrap=="circular"&&this.options.size!==null&&(e<=0||e>this.options.size))j=this.get(this.index(e)),j.length&&(h=this.add(e,j.clone(!0)))}j=h;l=this.dimension(h);if(l===0)throw Error("jCarousel: No width/height set for items. This will cause an infinite loop. Aborting..."); this.options.wrap!="circular"&&this.options.size!==null&&e>this.options.size?m.push(h):k&&(i+=l);n+=l;if(n>=g)break;e++}for(h=0;h<m.length;h++)m[h].remove();i>0&&(this.list.css(this.wh,this.dimension(this.list)+i+"px"),d&&(b-=i,this.list.css(this.lt,f.intval(this.list.css(this.lt))-i+"px")));i=a+o-1;if(this.options.wrap!="circular"&&this.options.size&&i>this.options.size)i=this.options.size;if(e>i){o=0;e=i;for(n=0;++o;){h=this.get(e--);if(!h.length)break;n+=this.dimension(h);if(n>=g)break}}e=i-o+ 1;this.options.wrap!="circular"&&e<1&&(e=1);if(this.inTail&&d)b+=this.tail,this.inTail=!1;this.tail=null;if(this.options.wrap!="circular"&&i==this.options.size&&i-o+1>=1&&(d=f.intval(this.get(i).css(!this.options.vertical?"marginRight":"marginBottom")),n-d>g))this.tail=n-g-d;if(c&&a===this.options.size&&this.tail)b-=this.tail,this.inTail=!0;for(;a-- >e;)b+=this.dimension(this.get(a));this.prevFirst=this.first;this.prevLast=this.last;this.first=e;this.last=i;return b},animate:function(a,c){if(!this.locked&& !this.animating){this.animating=!0;var b=this,d=function(){b.animating=!1;a===0&&b.list.css(b.lt,0);!b.autoStopped&&(b.options.wrap=="circular"||b.options.wrap=="both"||b.options.wrap=="last"||b.options.size===null||b.last<b.options.size||b.last==b.options.size&&b.tail!==null&&!b.inTail)&&b.startAuto();b.buttons();b.notify("onAfterAnimation");if(b.options.wrap=="circular"&&b.options.size!==null)for(var c=b.prevFirst;c<=b.prevLast;c++)c!==null&&!(c>=b.first&&c<=b.last)&&(c<1||c>b.options.size)&&b.remove(c)}; this.notify("onBeforeAnimation");if(!this.options.animation||c===!1)this.list.css(this.lt,a+"px"),d();else{var f=!this.options.vertical?this.options.rtl?{right:a}:{left:a}:{top:a},d={duration:this.options.animation,easing:this.options.easing,complete:d};if(g.isFunction(this.options.animationStepCallback))d.step=this.options.animationStepCallback;this.list.animate(f,d)}}},startAuto:function(a){if(a!==void 0)this.options.auto=a;if(this.options.auto===0)return this.stopAuto();if(this.timer===null){this.autoStopped= !1;var c=this;this.timer=window.setTimeout(function(){c.next()},this.options.auto*1E3)}},stopAuto:function(){this.pauseAuto();this.autoStopped=!0},pauseAuto:function(){if(this.timer!==null)window.clearTimeout(this.timer),this.timer=null},buttons:function(a,c){if(a==null&&(a=!this.locked&&this.options.size!==0&&(this.options.wrap&&this.options.wrap!="first"||this.options.size===null||this.last<this.options.size),!this.locked&&(!this.options.wrap||this.options.wrap=="first")&&this.options.size!==null&& this.last>=this.options.size))a=this.tail!==null&&!this.inTail;if(c==null&&(c=!this.locked&&this.options.size!==0&&(this.options.wrap&&this.options.wrap!="last"||this.first>1),!this.locked&&(!this.options.wrap||this.options.wrap=="last")&&this.options.size!==null&&this.first==1))c=this.tail!==null&&this.inTail;var b=this;this.buttonNext.size()>0?(this.buttonNext.unbind(this.options.buttonNextEvent+".jcarousel",this.funcNext),a&&this.buttonNext.bind(this.options.buttonNextEvent+".jcarousel",this.funcNext), this.buttonNext[a?"removeClass":"addClass"](this.className("jcarousel-next-disabled")).attr("disabled",a?!1:!0),this.options.buttonNextCallback!==null&&this.buttonNext.data("jcarouselstate")!=a&&this.buttonNext.each(function(){b.options.buttonNextCallback(b,this,a)}).data("jcarouselstate",a)):this.options.buttonNextCallback!==null&&this.buttonNextState!=a&&this.options.buttonNextCallback(b,null,a);this.buttonPrev.size()>0?(this.buttonPrev.unbind(this.options.buttonPrevEvent+".jcarousel",this.funcPrev), c&&this.buttonPrev.bind(this.options.buttonPrevEvent+".jcarousel",this.funcPrev),this.buttonPrev[c?"removeClass":"addClass"](this.className("jcarousel-prev-disabled")).attr("disabled",c?!1:!0),this.options.buttonPrevCallback!==null&&this.buttonPrev.data("jcarouselstate")!=c&&this.buttonPrev.each(function(){b.options.buttonPrevCallback(b,this,c)}).data("jcarouselstate",c)):this.options.buttonPrevCallback!==null&&this.buttonPrevState!=c&&this.options.buttonPrevCallback(b,null,c);this.buttonNextState= a;this.buttonPrevState=c},notify:function(a){var c=this.prevFirst===null?"init":this.prevFirst<this.first?"next":"prev";this.callback("itemLoadCallback",a,c);this.prevFirst!==this.first&&(this.callback("itemFirstInCallback",a,c,this.first),this.callback("itemFirstOutCallback",a,c,this.prevFirst));this.prevLast!==this.last&&(this.callback("itemLastInCallback",a,c,this.last),this.callback("itemLastOutCallback",a,c,this.prevLast));this.callback("itemVisibleInCallback",a,c,this.first,this.last,this.prevFirst, this.prevLast);this.callback("itemVisibleOutCallback",a,c,this.prevFirst,this.prevLast,this.first,this.last)},callback:function(a,c,b,d,f,j,e){if(!(this.options[a]==null||typeof this.options[a]!="object"&&c!="onAfterAnimation")){var h=typeof this.options[a]=="object"?this.options[a][c]:this.options[a];if(g.isFunction(h)){var i=this;if(d===void 0)h(i,b,c);else if(f===void 0)this.get(d).each(function(){h(i,this,d,b,c)});else for(var a=function(a){i.get(a).each(function(){h(i,this,a,b,c)})},k=d;k<=f;k++)k!== null&&!(k>=j&&k<=e)&&a(k)}}},create:function(a){return this.format("<li></li>",a)},format:function(a,c){for(var a=g(a),b=a.get(0).className.split(" "),d=0;d<b.length;d++)b[d].indexOf("jcarousel-")!=-1&&a.removeClass(b[d]);a.addClass(this.className("jcarousel-item")).addClass(this.className("jcarousel-item-"+c)).css({"float":this.options.rtl?"right":"left","list-style":"none"}).attr("jcarouselindex",c);return a},className:function(a){return a+" "+a+(!this.options.vertical?"-horizontal":"-vertical")}, dimension:function(a,c){var b=g(a);if(c==null)return!this.options.vertical?b.outerWidth(!0)||f.intval(this.options.itemFallbackDimension):b.outerHeight(!0)||f.intval(this.options.itemFallbackDimension);else{var d=!this.options.vertical?c-f.intval(b.css("marginLeft"))-f.intval(b.css("marginRight")):c-f.intval(b.css("marginTop"))-f.intval(b.css("marginBottom"));g(b).css(this.wh,d+"px");return this.dimension(b)}},clipping:function(){return!this.options.vertical?this.clip[0].offsetWidth-f.intval(this.clip.css("borderLeftWidth"))- f.intval(this.clip.css("borderRightWidth")):this.clip[0].offsetHeight-f.intval(this.clip.css("borderTopWidth"))-f.intval(this.clip.css("borderBottomWidth"))},index:function(a,c){if(c==null)c=this.options.size;return Math.round(((a-1)/c-Math.floor((a-1)/c))*c)+1}});f.extend({defaults:function(a){return g.extend(q,a||{})},intval:function(a){a=parseInt(a,10);return isNaN(a)?0:a},windowLoaded:function(){m=!0}});g.fn.jcarousel=function(a){if(typeof a=="string"){var c=g(this).data("jcarousel"),b=Array.prototype.slice.call(arguments, 1);return c[a].apply(c,b)}else return this.each(function(){var b=g(this).data("jcarousel");b?(a&&g.extend(b.options,a),b.reload()):g(this).data("jcarousel",new f(this,a))})}
})(jQuery);


/**
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright Â© 2008 George McGinley Smith
 * All rights reserved. 
 */
// t: current time, b: begInnIng value, c: change In value, d: duration
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('h.i[\'1a\']=h.i[\'z\'];h.O(h.i,{y:\'D\',z:9(x,t,b,c,d){6 h.i[h.i.y](x,t,b,c,d)},17:9(x,t,b,c,d){6 c*(t/=d)*t+b},D:9(x,t,b,c,d){6-c*(t/=d)*(t-2)+b},13:9(x,t,b,c,d){e((t/=d/2)<1)6 c/2*t*t+b;6-c/2*((--t)*(t-2)-1)+b},X:9(x,t,b,c,d){6 c*(t/=d)*t*t+b},U:9(x,t,b,c,d){6 c*((t=t/d-1)*t*t+1)+b},R:9(x,t,b,c,d){e((t/=d/2)<1)6 c/2*t*t*t+b;6 c/2*((t-=2)*t*t+2)+b},N:9(x,t,b,c,d){6 c*(t/=d)*t*t*t+b},M:9(x,t,b,c,d){6-c*((t=t/d-1)*t*t*t-1)+b},L:9(x,t,b,c,d){e((t/=d/2)<1)6 c/2*t*t*t*t+b;6-c/2*((t-=2)*t*t*t-2)+b},K:9(x,t,b,c,d){6 c*(t/=d)*t*t*t*t+b},J:9(x,t,b,c,d){6 c*((t=t/d-1)*t*t*t*t+1)+b},I:9(x,t,b,c,d){e((t/=d/2)<1)6 c/2*t*t*t*t*t+b;6 c/2*((t-=2)*t*t*t*t+2)+b},G:9(x,t,b,c,d){6-c*8.C(t/d*(8.g/2))+c+b},15:9(x,t,b,c,d){6 c*8.n(t/d*(8.g/2))+b},12:9(x,t,b,c,d){6-c/2*(8.C(8.g*t/d)-1)+b},Z:9(x,t,b,c,d){6(t==0)?b:c*8.j(2,10*(t/d-1))+b},Y:9(x,t,b,c,d){6(t==d)?b+c:c*(-8.j(2,-10*t/d)+1)+b},W:9(x,t,b,c,d){e(t==0)6 b;e(t==d)6 b+c;e((t/=d/2)<1)6 c/2*8.j(2,10*(t-1))+b;6 c/2*(-8.j(2,-10*--t)+2)+b},V:9(x,t,b,c,d){6-c*(8.o(1-(t/=d)*t)-1)+b},S:9(x,t,b,c,d){6 c*8.o(1-(t=t/d-1)*t)+b},Q:9(x,t,b,c,d){e((t/=d/2)<1)6-c/2*(8.o(1-t*t)-1)+b;6 c/2*(8.o(1-(t-=2)*t)+1)+b},P:9(x,t,b,c,d){f s=1.l;f p=0;f a=c;e(t==0)6 b;e((t/=d)==1)6 b+c;e(!p)p=d*.3;e(a<8.w(c)){a=c;f s=p/4}m f s=p/(2*8.g)*8.r(c/a);6-(a*8.j(2,10*(t-=1))*8.n((t*d-s)*(2*8.g)/p))+b},H:9(x,t,b,c,d){f s=1.l;f p=0;f a=c;e(t==0)6 b;e((t/=d)==1)6 b+c;e(!p)p=d*.3;e(a<8.w(c)){a=c;f s=p/4}m f s=p/(2*8.g)*8.r(c/a);6 a*8.j(2,-10*t)*8.n((t*d-s)*(2*8.g)/p)+c+b},T:9(x,t,b,c,d){f s=1.l;f p=0;f a=c;e(t==0)6 b;e((t/=d/2)==2)6 b+c;e(!p)p=d*(.3*1.5);e(a<8.w(c)){a=c;f s=p/4}m f s=p/(2*8.g)*8.r(c/a);e(t<1)6-.5*(a*8.j(2,10*(t-=1))*8.n((t*d-s)*(2*8.g)/p))+b;6 a*8.j(2,-10*(t-=1))*8.n((t*d-s)*(2*8.g)/p)*.5+c+b},F:9(x,t,b,c,d,s){e(s==u)s=1.l;6 c*(t/=d)*t*((s+1)*t-s)+b},E:9(x,t,b,c,d,s){e(s==u)s=1.l;6 c*((t=t/d-1)*t*((s+1)*t+s)+1)+b},16:9(x,t,b,c,d,s){e(s==u)s=1.l;e((t/=d/2)<1)6 c/2*(t*t*(((s*=(1.B))+1)*t-s))+b;6 c/2*((t-=2)*t*(((s*=(1.B))+1)*t+s)+2)+b},A:9(x,t,b,c,d){6 c-h.i.v(x,d-t,0,c,d)+b},v:9(x,t,b,c,d){e((t/=d)<(1/2.k)){6 c*(7.q*t*t)+b}m e(t<(2/2.k)){6 c*(7.q*(t-=(1.5/2.k))*t+.k)+b}m e(t<(2.5/2.k)){6 c*(7.q*(t-=(2.14/2.k))*t+.11)+b}m{6 c*(7.q*(t-=(2.18/2.k))*t+.19)+b}},1b:9(x,t,b,c,d){e(t<d/2)6 h.i.A(x,t*2,0,c,d)*.5+b;6 h.i.v(x,t*2-d,0,c,d)*.5+c*.5+b}});',62,74,'||||||return||Math|function|||||if|var|PI|jQuery|easing|pow|75|70158|else|sin|sqrt||5625|asin|||undefined|easeOutBounce|abs||def|swing|easeInBounce|525|cos|easeOutQuad|easeOutBack|easeInBack|easeInSine|easeOutElastic|easeInOutQuint|easeOutQuint|easeInQuint|easeInOutQuart|easeOutQuart|easeInQuart|extend|easeInElastic|easeInOutCirc|easeInOutCubic|easeOutCirc|easeInOutElastic|easeOutCubic|easeInCirc|easeInOutExpo|easeInCubic|easeOutExpo|easeInExpo||9375|easeInOutSine|easeInOutQuad|25|easeOutSine|easeInOutBack|easeInQuad|625|984375|jswing|easeInOutBounce'.split('|'),0,{}))


/**
 * Cycle Plugin
 *
 * @link http://jquery.malsup.com/cycle/
 */
;(function($){
	var ver='2.9995';if($.support==undefined){$.support={opacity:!($.browser.msie)};}
	function debug(s){$.fn.cycle.debug&&log(s);}
	function log(){window.console&&console.log&&console.log('[cycle] '+Array.prototype.join.call(arguments,' '));}
	$.expr[':'].paused=function(el){return el.cyclePause;}
	$.fn.cycle=function(options,arg2){var o={s:this.selector,c:this.context};if(this.length===0&&options!='stop'){if(!$.isReady&&o.s){log('DOM not ready, queuing slideshow');$(function(){$(o.s,o.c).cycle(options,arg2);});return this;}
	log('terminating; zero elements found by selector'+($.isReady?'':' (DOM not ready)'));return this;}
	return this.each(function(){var opts=handleArguments(this,options,arg2);if(opts===false)
	return;opts.updateActivePagerLink=opts.updateActivePagerLink||$.fn.cycle.updateActivePagerLink;if(this.cycleTimeout)
	clearTimeout(this.cycleTimeout);this.cycleTimeout=this.cyclePause=0;var $cont=$(this);var $slides=opts.slideExpr?$(opts.slideExpr,this):$cont.children();var els=$slides.get();var opts2=buildOptions($cont,$slides,els,opts,o);if(opts2===false)
	return;if(els.length<2){log('terminating; too few slides: '+els.length);return;}
	var startTime=opts2.continuous?10:getTimeout(els[opts2.currSlide],els[opts2.nextSlide],opts2,!opts2.backwards);if(startTime){startTime+=(opts2.delay||0);if(startTime<10)
	startTime=10;debug('first timeout: '+startTime);this.cycleTimeout=setTimeout(function(){go(els,opts2,0,!opts.backwards)},startTime);}});};function triggerPause(cont,byHover,onPager){var opts=$(cont).data('cycle.opts');var paused=!!cont.cyclePause;if(paused&&opts.paused)
	opts.paused(cont,opts,byHover,onPager);else if(!paused&&opts.resumed)
	opts.resumed(cont,opts,byHover,onPager);}
	function handleArguments(cont,options,arg2){if(cont.cycleStop==undefined)
	cont.cycleStop=0;if(options===undefined||options===null)
	options={};if(options.constructor==String){switch(options){case'destroy':case'stop':var opts=$(cont).data('cycle.opts');if(!opts)
	return false;cont.cycleStop++;if(cont.cycleTimeout)
	clearTimeout(cont.cycleTimeout);cont.cycleTimeout=0;opts.elements&&$(opts.elements).stop();$(cont).removeData('cycle.opts');if(options=='destroy')
	destroy(opts);return false;case'toggle':cont.cyclePause=(cont.cyclePause===1)?0:1;checkInstantResume(cont.cyclePause,arg2,cont);triggerPause(cont);return false;case'pause':cont.cyclePause=1;triggerPause(cont);return false;case'resume':cont.cyclePause=0;checkInstantResume(false,arg2,cont);triggerPause(cont);return false;case'prev':case'next':var opts=$(cont).data('cycle.opts');if(!opts){log('options not found, "prev/next" ignored');return false;}
	$.fn.cycle[options](opts);return false;default:options={fx:options};};return options;}
	else if(options.constructor==Number){var num=options;options=$(cont).data('cycle.opts');if(!options){log('options not found, can not advance slide');return false;}
	if(num<0||num>=options.elements.length){log('invalid slide index: '+num);return false;}
	options.nextSlide=num;if(cont.cycleTimeout){clearTimeout(cont.cycleTimeout);cont.cycleTimeout=0;}
	if(typeof arg2=='string')
	options.oneTimeFx=arg2;go(options.elements,options,1,num>=options.currSlide);return false;}
	return options;function checkInstantResume(isPaused,arg2,cont){if(!isPaused&&arg2===true){var options=$(cont).data('cycle.opts');if(!options){log('options not found, can not resume');return false;}
	if(cont.cycleTimeout){clearTimeout(cont.cycleTimeout);cont.cycleTimeout=0;}
	go(options.elements,options,1,!options.backwards);}}};function removeFilter(el,opts){if(!$.support.opacity&&opts.cleartype&&el.style.filter){try{el.style.removeAttribute('filter');}
	catch(smother){}}};function destroy(opts){if(opts.next)
	$(opts.next).unbind(opts.prevNextEvent);if(opts.prev)
	$(opts.prev).unbind(opts.prevNextEvent);if(opts.pager||opts.pagerAnchorBuilder)
	$.each(opts.pagerAnchors||[],function(){this.unbind().remove();});opts.pagerAnchors=null;if(opts.destroy)
	opts.destroy(opts);};function buildOptions($cont,$slides,els,options,o){var opts=$.extend({},$.fn.cycle.defaults,options||{},$.metadata?$cont.metadata():$.meta?$cont.data():{});var meta=$.isFunction($cont.data)?$cont.data(opts.metaAttr):null;if(meta)
	opts=$.extend(opts,meta);if(opts.autostop)
	opts.countdown=opts.autostopCount||els.length;var cont=$cont[0];$cont.data('cycle.opts',opts);opts.$cont=$cont;opts.stopCount=cont.cycleStop;opts.elements=els;opts.before=opts.before?[opts.before]:[];opts.after=opts.after?[opts.after]:[];if(!$.support.opacity&&opts.cleartype)
	opts.after.push(function(){removeFilter(this,opts);});if(opts.continuous)
	opts.after.push(function(){go(els,opts,0,!opts.backwards);});saveOriginalOpts(opts);if(!$.support.opacity&&opts.cleartype&&!opts.cleartypeNoBg)
	clearTypeFix($slides);if($cont.css('position')=='static')
	$cont.css('position','relative');if(opts.width)
	$cont.width(opts.width);if(opts.height&&opts.height!='auto')
	$cont.height(opts.height);if(opts.startingSlide)
	opts.startingSlide=parseInt(opts.startingSlide,10);else if(opts.backwards)
	opts.startingSlide=els.length-1;if(opts.random){opts.randomMap=[];for(var i=0;i<els.length;i++)
	opts.randomMap.push(i);opts.randomMap.sort(function(a,b){return Math.random()-0.5;});opts.randomIndex=1;opts.startingSlide=opts.randomMap[1];}
	else if(opts.startingSlide>=els.length)
	opts.startingSlide=0;opts.currSlide=opts.startingSlide||0;var first=opts.startingSlide;$slides.css({position:'absolute',top:0,left:0}).hide().each(function(i){var z;if(opts.backwards)
	z=first?i<=first?els.length+(i-first):first-i:els.length-i;else
	z=first?i>=first?els.length-(i-first):first-i:els.length-i;$(this).css('z-index',z)});$(els[first]).css('opacity',1).show();removeFilter(els[first],opts);if(opts.fit){if(!opts.aspect){if(opts.width)
	$slides.width(opts.width);if(opts.height&&opts.height!='auto')
	$slides.height(opts.height);}else{$slides.each(function(){var $slide=$(this);var ratio=(opts.aspect===true)?$slide.width()/$slide.height():opts.aspect;if(opts.width&&$slide.width()!=opts.width){$slide.width(opts.width);$slide.height(opts.width/ratio);}
	if(opts.height&&$slide.height()<opts.height){$slide.height(opts.height);$slide.width(opts.height*ratio);}});}}
	if(opts.center&&((!opts.fit)||opts.aspect)){$slides.each(function(){var $slide=$(this);$slide.css({"margin-left":opts.width?((opts.width-$slide.width())/2)+"px":0,"margin-top":opts.height?((opts.height-$slide.height())/2)+"px":0});});}
	if(opts.center&&!opts.fit&&!opts.slideResize){$slides.each(function(){var $slide=$(this);$slide.css({"margin-left":opts.width?((opts.width-$slide.width())/2)+"px":0,"margin-top":opts.height?((opts.height-$slide.height())/2)+"px":0});});}
	var reshape=opts.containerResize&&!$cont.innerHeight();if(reshape){var maxw=0,maxh=0;for(var j=0;j<els.length;j++){var $e=$(els[j]),e=$e[0],w=$e.outerWidth(),h=$e.outerHeight();if(!w)w=e.offsetWidth||e.width||$e.attr('width');if(!h)h=e.offsetHeight||e.height||$e.attr('height');maxw=w>maxw?w:maxw;maxh=h>maxh?h:maxh;}
	if(maxw>0&&maxh>0)
	$cont.css({width:maxw+'px',height:maxh+'px'});}
	var pauseFlag=false;if(opts.pause)
	$cont.hover(function(){pauseFlag=true;this.cyclePause++;triggerPause(cont,true);},function(){pauseFlag&&this.cyclePause--;triggerPause(cont,true);});if(supportMultiTransitions(opts)===false)
	return false;var requeue=false;options.requeueAttempts=options.requeueAttempts||0;$slides.each(function(){var $el=$(this);this.cycleH=(opts.fit&&opts.height)?opts.height:($el.height()||this.offsetHeight||this.height||$el.attr('height')||0);this.cycleW=(opts.fit&&opts.width)?opts.width:($el.width()||this.offsetWidth||this.width||$el.attr('width')||0);if($el.is('img')){var loadingIE=($.browser.msie&&this.cycleW==28&&this.cycleH==30&&!this.complete);var loadingFF=($.browser.mozilla&&this.cycleW==34&&this.cycleH==19&&!this.complete);var loadingOp=($.browser.opera&&((this.cycleW==42&&this.cycleH==19)||(this.cycleW==37&&this.cycleH==17))&&!this.complete);var loadingOther=(this.cycleH==0&&this.cycleW==0&&!this.complete);if(loadingIE||loadingFF||loadingOp||loadingOther){if(o.s&&opts.requeueOnImageNotLoaded&&++options.requeueAttempts<100){log(options.requeueAttempts,' - img slide not loaded, requeuing slideshow: ',this.src,this.cycleW,this.cycleH);setTimeout(function(){$(o.s,o.c).cycle(options)},opts.requeueTimeout);requeue=true;return false;}
	else{log('could not determine size of image: '+this.src,this.cycleW,this.cycleH);}}}
	return true;});if(requeue)
	return false;opts.cssBefore=opts.cssBefore||{};opts.cssAfter=opts.cssAfter||{};opts.cssFirst=opts.cssFirst||{};opts.animIn=opts.animIn||{};opts.animOut=opts.animOut||{};$slides.not(':eq('+first+')').css(opts.cssBefore);$($slides[first]).css(opts.cssFirst);if(opts.timeout){opts.timeout=parseInt(opts.timeout,10);if(opts.speed.constructor==String)
	opts.speed=$.fx.speeds[opts.speed]||parseInt(opts.speed,10);if(!opts.sync)
	opts.speed=opts.speed/2;var buffer=opts.fx=='none'?0:opts.fx=='shuffle'?500:250;while((opts.timeout-opts.speed)<buffer)
	opts.timeout+=opts.speed;}
	if(opts.easing)
	opts.easeIn=opts.easeOut=opts.easing;if(!opts.speedIn)
	opts.speedIn=opts.speed;if(!opts.speedOut)
	opts.speedOut=opts.speed;opts.slideCount=els.length;opts.currSlide=opts.lastSlide=first;if(opts.random){if(++opts.randomIndex==els.length)
	opts.randomIndex=0;opts.nextSlide=opts.randomMap[opts.randomIndex];}
	else if(opts.backwards)
	opts.nextSlide=opts.startingSlide==0?(els.length-1):opts.startingSlide-1;else
	opts.nextSlide=opts.startingSlide>=(els.length-1)?0:opts.startingSlide+1;if(!opts.multiFx){var init=$.fn.cycle.transitions[opts.fx];if($.isFunction(init))
	init($cont,$slides,opts);else if(opts.fx!='custom'&&!opts.multiFx){log('unknown transition: '+opts.fx,'; slideshow terminating');return false;}}
	var e0=$slides[first];if(!opts.skipInitializationCallbacks){if(opts.before.length)
	opts.before[0].apply(e0,[e0,e0,opts,true]);if(opts.after.length)
	opts.after[0].apply(e0,[e0,e0,opts,true]);}
	if(opts.next)
	$(opts.next).bind(opts.prevNextEvent,function(){return advance(opts,1)});if(opts.prev)
	$(opts.prev).bind(opts.prevNextEvent,function(){return advance(opts,0)});if(opts.pager||opts.pagerAnchorBuilder)
	buildPager(els,opts);exposeAddSlide(opts,els);return opts;};function saveOriginalOpts(opts){opts.original={before:[],after:[]};opts.original.cssBefore=$.extend({},opts.cssBefore);opts.original.cssAfter=$.extend({},opts.cssAfter);opts.original.animIn=$.extend({},opts.animIn);opts.original.animOut=$.extend({},opts.animOut);$.each(opts.before,function(){opts.original.before.push(this);});$.each(opts.after,function(){opts.original.after.push(this);});};function supportMultiTransitions(opts){var i,tx,txs=$.fn.cycle.transitions;if(opts.fx.indexOf(',')>0){opts.multiFx=true;opts.fxs=opts.fx.replace(/\s*/g,'').split(',');for(i=0;i<opts.fxs.length;i++){var fx=opts.fxs[i];tx=txs[fx];if(!tx||!txs.hasOwnProperty(fx)||!$.isFunction(tx)){log('discarding unknown transition: ',fx);opts.fxs.splice(i,1);i--;}}
	if(!opts.fxs.length){log('No valid transitions named; slideshow terminating.');return false;}}
	else if(opts.fx=='all'){opts.multiFx=true;opts.fxs=[];for(p in txs){tx=txs[p];if(txs.hasOwnProperty(p)&&$.isFunction(tx))
	opts.fxs.push(p);}}
	if(opts.multiFx&&opts.randomizeEffects){var r1=Math.floor(Math.random()*20)+30;for(i=0;i<r1;i++){var r2=Math.floor(Math.random()*opts.fxs.length);opts.fxs.push(opts.fxs.splice(r2,1)[0]);}
	debug('randomized fx sequence: ',opts.fxs);}
	return true;};function exposeAddSlide(opts,els){opts.addSlide=function(newSlide,prepend){var $s=$(newSlide),s=$s[0];if(!opts.autostopCount)
	opts.countdown++;els[prepend?'unshift':'push'](s);if(opts.els)
	opts.els[prepend?'unshift':'push'](s);opts.slideCount=els.length;$s.css('position','absolute');$s[prepend?'prependTo':'appendTo'](opts.$cont);if(prepend){opts.currSlide++;opts.nextSlide++;}
	if(!$.support.opacity&&opts.cleartype&&!opts.cleartypeNoBg)
	clearTypeFix($s);if(opts.fit&&opts.width)
	$s.width(opts.width);if(opts.fit&&opts.height&&opts.height!='auto')
	$s.height(opts.height);s.cycleH=(opts.fit&&opts.height)?opts.height:$s.height();s.cycleW=(opts.fit&&opts.width)?opts.width:$s.width();$s.css(opts.cssBefore);if(opts.pager||opts.pagerAnchorBuilder)
	$.fn.cycle.createPagerAnchor(els.length-1,s,$(opts.pager),els,opts);if($.isFunction(opts.onAddSlide))
	opts.onAddSlide($s);else
	$s.hide();};}
	$.fn.cycle.resetState=function(opts,fx){fx=fx||opts.fx;opts.before=[];opts.after=[];opts.cssBefore=$.extend({},opts.original.cssBefore);opts.cssAfter=$.extend({},opts.original.cssAfter);opts.animIn=$.extend({},opts.original.animIn);opts.animOut=$.extend({},opts.original.animOut);opts.fxFn=null;$.each(opts.original.before,function(){opts.before.push(this);});$.each(opts.original.after,function(){opts.after.push(this);});var init=$.fn.cycle.transitions[fx];if($.isFunction(init))
	init(opts.$cont,$(opts.elements),opts);};function go(els,opts,manual,fwd){if(manual&&opts.busy&&opts.manualTrump){debug('manualTrump in go(), stopping active transition');$(els).stop(true,true);opts.busy=0;}
	if(opts.busy){debug('transition active, ignoring new tx request');return;}
	var p=opts.$cont[0],curr=els[opts.currSlide],next=els[opts.nextSlide];if(p.cycleStop!=opts.stopCount||p.cycleTimeout===0&&!manual)
	return;if(!manual&&!p.cyclePause&&!opts.bounce&&((opts.autostop&&(--opts.countdown<=0))||(opts.nowrap&&!opts.random&&opts.nextSlide<opts.currSlide))){if(opts.end)
	opts.end(opts);return;}
	var changed=false;if((manual||!p.cyclePause)&&(opts.nextSlide!=opts.currSlide)){changed=true;var fx=opts.fx;curr.cycleH=curr.cycleH||$(curr).height();curr.cycleW=curr.cycleW||$(curr).width();next.cycleH=next.cycleH||$(next).height();next.cycleW=next.cycleW||$(next).width();if(opts.multiFx){if(fwd&&(opts.lastFx==undefined||++opts.lastFx>=opts.fxs.length))
	opts.lastFx=0;else if(!fwd&&(opts.lastFx==undefined||--opts.lastFx<0))
	opts.lastFx=opts.fxs.length-1;fx=opts.fxs[opts.lastFx];}
	if(opts.oneTimeFx){fx=opts.oneTimeFx;opts.oneTimeFx=null;}
	$.fn.cycle.resetState(opts,fx);if(opts.before.length)
	$.each(opts.before,function(i,o){if(p.cycleStop!=opts.stopCount)return;o.apply(next,[curr,next,opts,fwd]);});var after=function(){opts.busy=0;$.each(opts.after,function(i,o){if(p.cycleStop!=opts.stopCount)return;o.apply(next,[curr,next,opts,fwd]);});};debug('tx firing('+fx+'); currSlide: '+opts.currSlide+'; nextSlide: '+opts.nextSlide);opts.busy=1;if(opts.fxFn)
	opts.fxFn(curr,next,opts,after,fwd,manual&&opts.fastOnEvent);else if($.isFunction($.fn.cycle[opts.fx]))
	$.fn.cycle[opts.fx](curr,next,opts,after,fwd,manual&&opts.fastOnEvent);else
	$.fn.cycle.custom(curr,next,opts,after,fwd,manual&&opts.fastOnEvent);}
	if(changed||opts.nextSlide==opts.currSlide){opts.lastSlide=opts.currSlide;if(opts.random){opts.currSlide=opts.nextSlide;if(++opts.randomIndex==els.length)
	opts.randomIndex=0;opts.nextSlide=opts.randomMap[opts.randomIndex];if(opts.nextSlide==opts.currSlide)
	opts.nextSlide=(opts.currSlide==opts.slideCount-1)?0:opts.currSlide+1;}
	else if(opts.backwards){var roll=(opts.nextSlide-1)<0;if(roll&&opts.bounce){opts.backwards=!opts.backwards;opts.nextSlide=1;opts.currSlide=0;}
	else{opts.nextSlide=roll?(els.length-1):opts.nextSlide-1;opts.currSlide=roll?0:opts.nextSlide+1;}}
	else{var roll=(opts.nextSlide+1)==els.length;if(roll&&opts.bounce){opts.backwards=!opts.backwards;opts.nextSlide=els.length-2;opts.currSlide=els.length-1;}
	else{opts.nextSlide=roll?0:opts.nextSlide+1;opts.currSlide=roll?els.length-1:opts.nextSlide-1;}}}
	if(changed&&opts.pager)
	opts.updateActivePagerLink(opts.pager,opts.currSlide,opts.activePagerClass);var ms=0;if(opts.timeout&&!opts.continuous)
	ms=getTimeout(els[opts.currSlide],els[opts.nextSlide],opts,fwd);else if(opts.continuous&&p.cyclePause)
	ms=10;if(ms>0)
	p.cycleTimeout=setTimeout(function(){go(els,opts,0,!opts.backwards)},ms);};$.fn.cycle.updateActivePagerLink=function(pager,currSlide,clsName){$(pager).each(function(){$(this).children().removeClass(clsName).eq(currSlide).addClass(clsName);});};function getTimeout(curr,next,opts,fwd){if(opts.timeoutFn){var t=opts.timeoutFn.call(curr,curr,next,opts,fwd);while(opts.fx!='none'&&(t-opts.speed)<250)
	t+=opts.speed;debug('calculated timeout: '+t+'; speed: '+opts.speed);if(t!==false)
	return t;}
	return opts.timeout;};$.fn.cycle.next=function(opts){advance(opts,1);};$.fn.cycle.prev=function(opts){advance(opts,0);};function advance(opts,moveForward){var val=moveForward?1:-1;var els=opts.elements;var p=opts.$cont[0],timeout=p.cycleTimeout;if(timeout){clearTimeout(timeout);p.cycleTimeout=0;}
	if(opts.random&&val<0){opts.randomIndex--;if(--opts.randomIndex==-2)
	opts.randomIndex=els.length-2;else if(opts.randomIndex==-1)
	opts.randomIndex=els.length-1;opts.nextSlide=opts.randomMap[opts.randomIndex];}
	else if(opts.random){opts.nextSlide=opts.randomMap[opts.randomIndex];}
	else{opts.nextSlide=opts.currSlide+val;if(opts.nextSlide<0){if(opts.nowrap)return false;opts.nextSlide=els.length-1;}
	else if(opts.nextSlide>=els.length){if(opts.nowrap)return false;opts.nextSlide=0;}}
	var cb=opts.onPrevNextEvent||opts.prevNextClick;if($.isFunction(cb))
	cb(val>0,opts.nextSlide,els[opts.nextSlide]);go(els,opts,1,moveForward);return false;};function buildPager(els,opts){var $p=$(opts.pager);$.each(els,function(i,o){$.fn.cycle.createPagerAnchor(i,o,$p,els,opts);});opts.updateActivePagerLink(opts.pager,opts.startingSlide,opts.activePagerClass);};$.fn.cycle.createPagerAnchor=function(i,el,$p,els,opts){var a;if($.isFunction(opts.pagerAnchorBuilder)){a=opts.pagerAnchorBuilder(i,el);debug('pagerAnchorBuilder('+i+', el) returned: '+a);}
	else
	a='<a href="#">'+(i+1)+'</a>';if(!a)
	return;var $a=$(a);if($a.parents('body').length===0){var arr=[];if($p.length>1){$p.each(function(){var $clone=$a.clone(true);$(this).append($clone);arr.push($clone[0]);});$a=$(arr);}
	else{$a.appendTo($p);}}
	opts.pagerAnchors=opts.pagerAnchors||[];opts.pagerAnchors.push($a);var pagerFn=function(e){e.preventDefault();opts.nextSlide=i;var p=opts.$cont[0],timeout=p.cycleTimeout;if(timeout){clearTimeout(timeout);p.cycleTimeout=0;}
	var cb=opts.onPagerEvent||opts.pagerClick;if($.isFunction(cb))
	cb(opts.nextSlide,els[opts.nextSlide]);go(els,opts,1,opts.currSlide<i);}
	if(/mouseenter|mouseover/i.test(opts.pagerEvent)){$a.hover(pagerFn,function(){});}
	else{$a.bind(opts.pagerEvent,pagerFn);}
	if(!/^click/.test(opts.pagerEvent)&&!opts.allowPagerClickBubble)
	$a.bind('click.cycle',function(){return false;});var cont=opts.$cont[0];var pauseFlag=false;if(opts.pauseOnPagerHover){$a.hover(function(){pauseFlag=true;cont.cyclePause++;triggerPause(cont,true,true);},function(){pauseFlag&&cont.cyclePause--;triggerPause(cont,true,true);});}};$.fn.cycle.hopsFromLast=function(opts,fwd){var hops,l=opts.lastSlide,c=opts.currSlide;if(fwd)
	hops=c>l?c-l:opts.slideCount-l;else
	hops=c<l?l-c:l+opts.slideCount-c;return hops;};function clearTypeFix($slides){debug('applying clearType background-color hack');function hex(s){s=parseInt(s,10).toString(16);return s.length<2?'0'+s:s;};function getBg(e){for(;e&&e.nodeName.toLowerCase()!='html';e=e.parentNode){var v=$.css(e,'background-color');if(v&&v.indexOf('rgb')>=0){var rgb=v.match(/\d+/g);return'#'+hex(rgb[0])+hex(rgb[1])+hex(rgb[2]);}
	if(v&&v!='transparent')
	return v;}
	return'#ffffff';};$slides.each(function(){$(this).css('background-color',getBg(this));});};$.fn.cycle.commonReset=function(curr,next,opts,w,h,rev){$(opts.elements).not(curr).hide();if(typeof opts.cssBefore.opacity=='undefined')
	opts.cssBefore.opacity=1;opts.cssBefore.display='block';if(opts.slideResize&&w!==false&&next.cycleW>0)
	opts.cssBefore.width=next.cycleW;if(opts.slideResize&&h!==false&&next.cycleH>0)
	opts.cssBefore.height=next.cycleH;opts.cssAfter=opts.cssAfter||{};opts.cssAfter.display='none';$(curr).css('zIndex',opts.slideCount+(rev===true?1:0));$(next).css('zIndex',opts.slideCount+(rev===true?0:1));};$.fn.cycle.custom=function(curr,next,opts,cb,fwd,speedOverride){var $l=$(curr),$n=$(next);var speedIn=opts.speedIn,speedOut=opts.speedOut,easeIn=opts.easeIn,easeOut=opts.easeOut;$n.css(opts.cssBefore);if(speedOverride){if(typeof speedOverride=='number')
	speedIn=speedOut=speedOverride;else
	speedIn=speedOut=1;easeIn=easeOut=null;}
	var fn=function(){$n.animate(opts.animIn,speedIn,easeIn,function(){cb();});};$l.animate(opts.animOut,speedOut,easeOut,function(){$l.css(opts.cssAfter);if(!opts.sync)
	fn();});if(opts.sync)fn();};$.fn.cycle.transitions={fade:function($cont,$slides,opts){$slides.not(':eq('+opts.currSlide+')').css('opacity',0);opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts);opts.cssBefore.opacity=0;});opts.animIn={opacity:1};opts.animOut={opacity:0};opts.cssBefore={top:0,left:0};}};$.fn.cycle.ver=function(){return ver;};$.fn.cycle.defaults={activePagerClass:'activeSlide',after:null,allowPagerClickBubble:false,animIn:null,animOut:null,aspect:false,autostop:0,autostopCount:0,backwards:false,before:null,center:null,cleartype:!$.support.opacity,cleartypeNoBg:false,containerResize:1,continuous:0,cssAfter:null,cssBefore:null,delay:0,easeIn:null,easeOut:null,easing:null,end:null,fastOnEvent:0,fit:0,fx:'fade',fxFn:null,height:'auto',manualTrump:true,metaAttr:'cycle',next:null,nowrap:0,onPagerEvent:null,onPrevNextEvent:null,pager:null,pagerAnchorBuilder:null,pagerEvent:'click.cycle',pause:0,pauseOnPagerHover:0,prev:null,prevNextEvent:'click.cycle',random:0,randomizeEffects:1,requeueOnImageNotLoaded:true,requeueTimeout:250,rev:0,shuffle:null,skipInitializationCallbacks:false,slideExpr:null,slideResize:1,speed:1000,speedIn:null,speedOut:null,startingSlide:0,sync:1,timeout:4000,timeoutFn:null,updateActivePagerLink:null,width:null};})(jQuery);(function($){$.fn.cycle.transitions.none=function($cont,$slides,opts){opts.fxFn=function(curr,next,opts,after){$(next).show();$(curr).hide();after();};};$.fn.cycle.transitions.fadeout=function($cont,$slides,opts){$slides.not(':eq('+opts.currSlide+')').css({display:'block','opacity':1});opts.before.push(function(curr,next,opts,w,h,rev){$(curr).css('zIndex',opts.slideCount+(!rev===true?1:0));$(next).css('zIndex',opts.slideCount+(!rev===true?0:1));});opts.animIn.opacity=1;opts.animOut.opacity=0;opts.cssBefore.opacity=1;opts.cssBefore.display='block';opts.cssAfter.zIndex=0;};$.fn.cycle.transitions.scrollUp=function($cont,$slides,opts){$cont.css('overflow','hidden');opts.before.push($.fn.cycle.commonReset);var h=$cont.height();opts.cssBefore.top=h;opts.cssBefore.left=0;opts.cssFirst.top=0;opts.animIn.top=0;opts.animOut.top=-h;};$.fn.cycle.transitions.scrollDown=function($cont,$slides,opts){$cont.css('overflow','hidden');opts.before.push($.fn.cycle.commonReset);var h=$cont.height();opts.cssFirst.top=0;opts.cssBefore.top=-h;opts.cssBefore.left=0;opts.animIn.top=0;opts.animOut.top=h;};$.fn.cycle.transitions.scrollLeft=function($cont,$slides,opts){$cont.css('overflow','hidden');opts.before.push($.fn.cycle.commonReset);var w=$cont.width();opts.cssFirst.left=0;opts.cssBefore.left=w;opts.cssBefore.top=0;opts.animIn.left=0;opts.animOut.left=0-w;};$.fn.cycle.transitions.scrollRight=function($cont,$slides,opts){$cont.css('overflow','hidden');opts.before.push($.fn.cycle.commonReset);var w=$cont.width();opts.cssFirst.left=0;opts.cssBefore.left=-w;opts.cssBefore.top=0;opts.animIn.left=0;opts.animOut.left=w;};$.fn.cycle.transitions.scrollHorz=function($cont,$slides,opts){$cont.css('overflow','hidden').width();opts.before.push(function(curr,next,opts,fwd){if(opts.rev)
	fwd=!fwd;$.fn.cycle.commonReset(curr,next,opts);opts.cssBefore.left=fwd?(next.cycleW-1):(1-next.cycleW);opts.animOut.left=fwd?-curr.cycleW:curr.cycleW;});opts.cssFirst.left=0;opts.cssBefore.top=0;opts.animIn.left=0;opts.animOut.top=0;};$.fn.cycle.transitions.scrollVert=function($cont,$slides,opts){$cont.css('overflow','hidden');opts.before.push(function(curr,next,opts,fwd){if(opts.rev)
	fwd=!fwd;$.fn.cycle.commonReset(curr,next,opts);opts.cssBefore.top=fwd?(1-next.cycleH):(next.cycleH-1);opts.animOut.top=fwd?curr.cycleH:-curr.cycleH;});opts.cssFirst.top=0;opts.cssBefore.left=0;opts.animIn.top=0;opts.animOut.left=0;};$.fn.cycle.transitions.slideX=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$(opts.elements).not(curr).hide();$.fn.cycle.commonReset(curr,next,opts,false,true);opts.animIn.width=next.cycleW;});opts.cssBefore.left=0;opts.cssBefore.top=0;opts.cssBefore.width=0;opts.animIn.width='show';opts.animOut.width=0;};$.fn.cycle.transitions.slideY=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$(opts.elements).not(curr).hide();$.fn.cycle.commonReset(curr,next,opts,true,false);opts.animIn.height=next.cycleH;});opts.cssBefore.left=0;opts.cssBefore.top=0;opts.cssBefore.height=0;opts.animIn.height='show';opts.animOut.height=0;};$.fn.cycle.transitions.shuffle=function($cont,$slides,opts){var i,w=$cont.css('overflow','visible').width();$slides.css({left:0,top:0});opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,true,true,true);});if(!opts.speedAdjusted){opts.speed=opts.speed/2;opts.speedAdjusted=true;}
	opts.random=0;opts.shuffle=opts.shuffle||{left:-w,top:15};opts.els=[];for(i=0;i<$slides.length;i++)
	opts.els.push($slides[i]);for(i=0;i<opts.currSlide;i++)
	opts.els.push(opts.els.shift());opts.fxFn=function(curr,next,opts,cb,fwd){if(opts.rev)
	fwd=!fwd;var $el=fwd?$(curr):$(next);$(next).css(opts.cssBefore);var count=opts.slideCount;$el.animate(opts.shuffle,opts.speedIn,opts.easeIn,function(){var hops=$.fn.cycle.hopsFromLast(opts,fwd);for(var k=0;k<hops;k++)
	fwd?opts.els.push(opts.els.shift()):opts.els.unshift(opts.els.pop());if(fwd){for(var i=0,len=opts.els.length;i<len;i++)
	$(opts.els[i]).css('z-index',len-i+count);}
	else{var z=$(curr).css('z-index');$el.css('z-index',parseInt(z,10)+1+count);}
	$el.animate({left:0,top:0},opts.speedOut,opts.easeOut,function(){$(fwd?this:curr).hide();if(cb)cb();});});};$.extend(opts.cssBefore,{display:'block',opacity:1,top:0,left:0});};$.fn.cycle.transitions.turnUp=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,true,false);opts.cssBefore.top=next.cycleH;opts.animIn.height=next.cycleH;opts.animOut.width=next.cycleW;});opts.cssFirst.top=0;opts.cssBefore.left=0;opts.cssBefore.height=0;opts.animIn.top=0;opts.animOut.height=0;};$.fn.cycle.transitions.turnDown=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,true,false);opts.animIn.height=next.cycleH;opts.animOut.top=curr.cycleH;});opts.cssFirst.top=0;opts.cssBefore.left=0;opts.cssBefore.top=0;opts.cssBefore.height=0;opts.animOut.height=0;};$.fn.cycle.transitions.turnLeft=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,false,true);opts.cssBefore.left=next.cycleW;opts.animIn.width=next.cycleW;});opts.cssBefore.top=0;opts.cssBefore.width=0;opts.animIn.left=0;opts.animOut.width=0;};$.fn.cycle.transitions.turnRight=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,false,true);opts.animIn.width=next.cycleW;opts.animOut.left=curr.cycleW;});$.extend(opts.cssBefore,{top:0,left:0,width:0});opts.animIn.left=0;opts.animOut.width=0;};$.fn.cycle.transitions.zoom=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,false,false,true);opts.cssBefore.top=next.cycleH/2;opts.cssBefore.left=next.cycleW/2;$.extend(opts.animIn,{top:0,left:0,width:next.cycleW,height:next.cycleH});$.extend(opts.animOut,{width:0,height:0,top:curr.cycleH/2,left:curr.cycleW/2});});opts.cssFirst.top=0;opts.cssFirst.left=0;opts.cssBefore.width=0;opts.cssBefore.height=0;};$.fn.cycle.transitions.fadeZoom=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,false,false);opts.cssBefore.left=next.cycleW/2;opts.cssBefore.top=next.cycleH/2;$.extend(opts.animIn,{top:0,left:0,width:next.cycleW,height:next.cycleH});});opts.cssBefore.width=0;opts.cssBefore.height=0;opts.animOut.opacity=0;};$.fn.cycle.transitions.blindX=function($cont,$slides,opts){var w=$cont.css('overflow','hidden').width();opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts);opts.animIn.width=next.cycleW;opts.animOut.left=curr.cycleW;});opts.cssBefore.left=w;opts.cssBefore.top=0;opts.animIn.left=0;opts.animOut.left=w;};$.fn.cycle.transitions.blindY=function($cont,$slides,opts){var h=$cont.css('overflow','hidden').height();opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts);opts.animIn.height=next.cycleH;opts.animOut.top=curr.cycleH;});opts.cssBefore.top=h;opts.cssBefore.left=0;opts.animIn.top=0;opts.animOut.top=h;};$.fn.cycle.transitions.blindZ=function($cont,$slides,opts){var h=$cont.css('overflow','hidden').height();var w=$cont.width();opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts);opts.animIn.height=next.cycleH;opts.animOut.top=curr.cycleH;});opts.cssBefore.top=h;opts.cssBefore.left=w;opts.animIn.top=0;opts.animIn.left=0;opts.animOut.top=h;opts.animOut.left=w;};$.fn.cycle.transitions.growX=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,false,true);opts.cssBefore.left=this.cycleW/2;opts.animIn.left=0;opts.animIn.width=this.cycleW;opts.animOut.left=0;});opts.cssBefore.top=0;opts.cssBefore.width=0;};$.fn.cycle.transitions.growY=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,true,false);opts.cssBefore.top=this.cycleH/2;opts.animIn.top=0;opts.animIn.height=this.cycleH;opts.animOut.top=0;});opts.cssBefore.height=0;opts.cssBefore.left=0;};$.fn.cycle.transitions.curtainX=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,false,true,true);opts.cssBefore.left=next.cycleW/2;opts.animIn.left=0;opts.animIn.width=this.cycleW;opts.animOut.left=curr.cycleW/2;opts.animOut.width=0;});opts.cssBefore.top=0;opts.cssBefore.width=0;};$.fn.cycle.transitions.curtainY=function($cont,$slides,opts){opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,true,false,true);opts.cssBefore.top=next.cycleH/2;opts.animIn.top=0;opts.animIn.height=next.cycleH;opts.animOut.top=curr.cycleH/2;opts.animOut.height=0;});opts.cssBefore.height=0;opts.cssBefore.left=0;};$.fn.cycle.transitions.cover=function($cont,$slides,opts){var d=opts.direction||'left';var w=$cont.css('overflow','hidden').width();var h=$cont.height();opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts);if(d=='right')
	opts.cssBefore.left=-w;else if(d=='up')
	opts.cssBefore.top=h;else if(d=='down')
	opts.cssBefore.top=-h;else
	opts.cssBefore.left=w;});opts.animIn.left=0;opts.animIn.top=0;opts.cssBefore.top=0;opts.cssBefore.left=0;};$.fn.cycle.transitions.uncover=function($cont,$slides,opts){var d=opts.direction||'left';var w=$cont.css('overflow','hidden').width();var h=$cont.height();opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,true,true,true);if(d=='right')
	opts.animOut.left=w;else if(d=='up')
	opts.animOut.top=-h;else if(d=='down')
	opts.animOut.top=h;else
	opts.animOut.left=-w;});opts.animIn.left=0;opts.animIn.top=0;opts.cssBefore.top=0;opts.cssBefore.left=0;};$.fn.cycle.transitions.toss=function($cont,$slides,opts){var w=$cont.css('overflow','visible').width();var h=$cont.height();opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts,true,true,true);if(!opts.animOut.left&&!opts.animOut.top)
	$.extend(opts.animOut,{left:w*2,top:-h/2,opacity:0});else
	opts.animOut.opacity=0;});opts.cssBefore.left=0;opts.cssBefore.top=0;opts.animIn.left=0;};$.fn.cycle.transitions.wipe=function($cont,$slides,opts){var w=$cont.css('overflow','hidden').width();var h=$cont.height();opts.cssBefore=opts.cssBefore||{};var clip;if(opts.clip){if(/l2r/.test(opts.clip))
	clip='rect(0px 0px '+h+'px 0px)';else if(/r2l/.test(opts.clip))
	clip='rect(0px '+w+'px '+h+'px '+w+'px)';else if(/t2b/.test(opts.clip))
	clip='rect(0px '+w+'px 0px 0px)';else if(/b2t/.test(opts.clip))
	clip='rect('+h+'px '+w+'px '+h+'px 0px)';else if(/zoom/.test(opts.clip)){var top=parseInt(h/2,10);var left=parseInt(w/2,10);clip='rect('+top+'px '+left+'px '+top+'px '+left+'px)';}}
	opts.cssBefore.clip=opts.cssBefore.clip||clip||'rect(0px 0px 0px 0px)';var d=opts.cssBefore.clip.match(/(\d+)/g);var t=parseInt(d[0],10),r=parseInt(d[1],10),b=parseInt(d[2],10),l=parseInt(d[3],10);opts.before.push(function(curr,next,opts){if(curr==next)return;var $curr=$(curr),$next=$(next);$.fn.cycle.commonReset(curr,next,opts,true,true,false);opts.cssAfter.display='block';var step=1,count=parseInt((opts.speedIn/13),10)-1;(function f(){var tt=t?t-parseInt(step*(t/count),10):0;var ll=l?l-parseInt(step*(l/count),10):0;var bb=b<h?b+parseInt(step*((h-b)/count||1),10):h;var rr=r<w?r+parseInt(step*((w-r)/count||1),10):w;$next.css({clip:'rect('+tt+'px '+rr+'px '+bb+'px '+ll+'px)'});(step++<=count)?setTimeout(f,13):$curr.css('display','none');})();});$.extend(opts.cssBefore,{display:'block',opacity:1,top:0,left:0});opts.animIn={left:0};opts.animOut={left:0};};

})(window.jQuery);


(function($) {

	/** 
	 * Animate down on subpages
	 *
	 */
	jQuery.fn.exists = function() {
		return $( this ).length > 0;
	}
	
	if ( $( 'body:not(.home)' ).exists() ) {
		$( 'html, body' ).animate({ 
			scrollTop: 399 
		}, 500 );
	}
	
	
	/** 
	 * Scroll Animation
	 *
	 */
	$( ".scroll" ).click( function( event ){
		//prevent the default action for the click event
		event.preventDefault();

		//get the full url - like mysitecom/index.htm#home
		var full_url = this.href;

		//split the url by # and get the anchor target name - home in mysitecom/index.htm#home
		var parts = full_url.split( "#" );
		var trgt = parts[1];

		//get the top offset of the target anchor
		var target_offset = $( "#" + trgt ).offset();
		var target_top = target_offset.top;

		//goto that anchor by setting the body scroll top to anchor top
		$('html, body').animate({
			scrollTop: target_top
		}, 500);
	});	
	
	
	/**
	 * Tooltip
	 *	
	 * @link http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
	 */
	this.tooltip = function(){	

			xTooltipOffset = 25;
			yTooltipOffset = 5;		

		$("a.tooltip").hover(function(e){											  
			this.t = this.title;
			this.title = "";									  
			$("body").append("<p id='tooltip'>"+ this.t +"</p>");
			$("#tooltip")
				.css("top",(e.pageY - xTooltipOffset) + "px")
				.css("left",(e.pageX + yTooltipOffset) + "px")
				.fadeIn("fast");		
	    },
		function(){
			this.title = this.t;		
			$("#tooltip").remove();
	    });	
		$("a.tooltip").mousemove(function(e){
			$("#tooltip")
				.css("top",(e.pageY - xTooltipOffset) + "px")
				.css("left",(e.pageX + yTooltipOffset) + "px");
		});			
	};
})(window.jQuery);




jQuery(document).ready(function($) {

/* FORMAT VIDEOS
----------------------------------------------- */
	$('#content .format-video').each( function(index, el) {
	    // Find the first oEmbed video
	    var formatVideoCache = $(this).contents().find('.wp-embed').first();
	    // Get the videos content
	    var formatVideoContent = $(formatVideoCache).html();
	    
	    // Place video in the .entry-video container
	    if( '' != formatVideoContent ) {
	        $('.entry-video', this).append(formatVideoContent);
	        $(formatVideoCache).remove();
	    }
	    
		/**
		 * Entry Content Cleanup
		 *
		 * Find all video post formats and remove the entry-content if empty.
		 * Because the video is posted in the content area, the entry-content
		 * div container is displayed because the content is technically not empty.
		 */ 
		$('.entry-content', this).filter( function() {
    	    return $.trim($(this).text()) === ''
    	}).remove()
	});
	
	
/* GET PARAMETER BY NAME
----------------------------------------------- */
	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regexS = "[\\?&]" + name + "=([^&#]*)";
		var regex = new RegExp(regexS);
		var results = regex.exec(window.location.search);
		if(results == null)
			return "";
		else
			return decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	
	
/* EVENTS FILTER & EFFECTS
----------------------------------------------- */
	// Filter Menu
	var filterLink = $('#events-filter-list #filter a');
	filterLink.click( function() {
	
		$('li.event').removeClass('inactive');
		
		filterLink.not(this).removeClass('active');
		$(this).addClass('active');
		
		var activeCat = $(this).attr('href').replace('#', '').toLowerCase();
		
		console.log(activeCat);
		
		$('#content li.event').not('li.'+ activeCat).addClass('inactive').children().stop(true,true).animate({opacity:".3"},350);
		$('#content li.'+ activeCat).children().stop(true,true).animate({opacity:"1"},350);
		
		return false;
	});
	
	// Make filter title width the same as the first date
	var filterTitleWidth = $('#events-date-list .event:first .event-date').width();
	$('#events-list .filter-title').css('width', filterTitleWidth);
	
	// Event Description Display
	$('#content .hentry .event').each( function() {
		var event = this;
		$(event).click( function() {
			$(event).toggleClass('active');
			$('.event-description', event).slideToggle('fast');
	    });
	});
	
	// Widget Settings
	var event_id = getParameterByName('event_id');
	if( event_id ) {
		var event_id = '#content #post-' + event_id;
		$(event_id).addClass('active');
		$('.event-description', event_id).slideDown('fast');
	}
		

/* FITVIDS (fitvids.js)
----------------------------------------------- */
	$('.player').fitVids({ 
		customSelector: "iframe[src^='http://dailymotion.com'], embed[src^='http://v.wordpress.com']"
	});


/* TOOLTIPS (init)
----------------------------------------------- */
	tooltip();
	
	
/* IMAGE CAROUSEL (init)
----------------------------------------------- */
	$('#image-carousel').jcarousel();
	
	
/* HERO SLIDER (Cycle Plugin)
----------------------------------------------- */
	// Set common vars
	var hero_obj = '#hero';
	var hero_slides = '#hero .slides';
	var hero_slide = '#hero .slide';
	var hero_embed = '#hero .entry-embed';
	var hero_gallery = '#hero .entry-gallery';
	var hero_prev = '#hero .prev';
	var hero_next = '#hero .next';
	var hero_edit_link = '#hero .edit-link';
	var hero_buttons = hero_prev + ', ' + hero_next + ', ' + hero_edit_link;
	
	// Hide Hero nav elements if there is only 1 slide
	if( $(hero_slide).length >= 1 ) {
	
		// Set new vars from localized slideshow options (functions.php)
		var hero_fx = hero_options.hero_fx;
		var hero_speed = hero_options.hero_speed;
		var hero_timeout = ( '0' == hero_options.hero_timeout ) ? 0 : hero_options.hero_timeout;
    	
		// Initiate cycle plugin
		$(hero_slides).cycle({
			fx: hero_fx,
			speed: hero_speed,
			timeout: hero_timeout,
			prev: hero_prev,
			next: hero_next,
			slideResize: true,
			containerResize: false,
			easing: 'easeInOutQuint',
			pause: true,
			pauseOnPagerHover: true
		});
		
		$(window).resize(function(){
			windowWidth = $(window).width();
			$(hero_slide).width(windowWidth);
		});
		
		/* Controls Display */
        $(hero_obj).hover(function() {
			$(hero_buttons).fadeTo("fast", 1);
        }, function() {
			$(hero_buttons).fadeTo("fast", 0);
        });
		
		/* Pause the slider when hover over a media element */
		$(hero_embed).hover(function() {
			hero_slides.cycle('pause');
		});
		
		/* Pause the slider when hover over a gallery element */
		$(hero_gallery).hover(function() {
			hero_slides.cycle('pause');
		}, function() {
			hero_slides.cycle('resume');
		});
		
		/* Resume slider if paused when hovering over nav elements */
		$(hero_prev + ', ' + hero_next).hover(function() {
			hero_slides.cycle('resume');
		});
	}


/* AUDIO PLAYER (jPlyaer)
----------------------------------------------- */
	// Misc (localized in functions.php)
	var templateDirectoryUri = jplayer_params.get_template_directory_uri;
	
	// Audio (localized in functions.php)
	var audioJson            = jplayer_params.format_audio.replace( /&quot;/g, '"');
	var audio                = $.parseJSON( audioJson );
	
	// Options (localized in functions.php)
	var options              = jplayer_params.options;
	var enable_autoplay      = options.enable_autoplay;
	var enable_playlist      = options.enable_playlist;
	
	// Check if playlist has a value
	if(audio.playlist) {
		$('[id^="jp_container_"]').each(function() {
		    var newID = this.id.replace(/jp_container_/, "");
		    var randID = newID.substr(0,4);
		    var theID = newID.substr(5);
	    	var theTracks = audio.playlist[theID];
	    	
	    	var thePlaylist = 'playlist' + randID + '_' + theID;
	    	var thePlayer = $('#jp_container_' + randID + '_' + theID );
	    	
	    	thePlaylist = new jPlayerPlaylist({
	    			jPlayer: "#jquery_jplayer_" + randID + '_' + theID,
	    			cssSelectorAncestor: "#jp_container_" + randID + '_' + theID
	    		}, 
	    			theTracks, // track list
	    		{
	    		playlistOptions: {
	    			enableRemoveControls: false,
	    			autoPlay: ( 1 == is_widget() ) ? 0 : enable_autoplay
	    		},
	    		swfPath: templateDirectoryUri + '/inc',
	    		supplied: 'mp3',
	    		wmode: 'window',
	    		preload: 'auto',
	    		solution: 'flash, html', // use flash player first, hides audio urls
				ready: function() {
				    on_ready();
				    add_track_number();
				    highlight_playable_tracks();
				},
	    		play: function() {
	    			on_play();
	    		},
	    		pause: function() {
	    			on_pause();
	    		},
	    		ended: function() {
	    			update_current_track_info();
	    		},
				error: function(event) {
					console.log("Error Event: type = " + event.jPlayer.error.type); // Helpful for debugging
					if ( 'e_url_not_set' == event.jPlayer.error.type ) {
						thePlaylist.next();
					}
				}
	    	});
	
	    	/** Update and Display functionality */
			var jpPlaylist     = $('.jp-type-playlist', thePlayer );
	    	var jpPlaylistView = $('.jp-playlist-view', thePlayer );
	    	var jpPlaylistNav  = $('.jp-playlist', thePlayer );
	    	var jpContent      = $('.jp-content', thePlayer );
	    	var jpContentView  = $('.jp-content-view', thePlayer );
	    	var jpTrack        = $('.jp-current-track span', thePlayer );
	    	var jpArtist       = $('.jp-current-artist span', thePlayer );
	    	var jpAlbum        = $('.jp-current-album span', thePlayer );
	    	var jpArtwork      = $('.jp-current-artwork img.artwork', thePlayer );
	    	var jpCurrentTime  = $('.jp-current-time-wrap', thePlayer );
			var jpNowPlaying   = $('.jp-now-playing', thePlayer );
			var jpNotifictions = $('.jp-notification', thePlayer );
			
	    	// Used for playlist_view() to only effect the content area and not the players in the sidebar.
	    	var jpPlaylistNavContent  = $('.single #content .jp-playlist' );
	    	
	    	// Update buttons
	    	$('.jp-next, .jp-previous, .jp-playlist-item').click( function() {
	    	    update_current_track_info();
	    	});
	    	
	    	// Show and Hide playlist
	    	jpPlaylistView.click(function(e){
	    	    e.preventDefault();
				if( jpPlaylistNav.is( ':visible') ) {
					show_hide_playlist();
					jpPlaylistView.removeClass( 'open' );
				} else {
					show_hide_playlist(true);
					jpPlaylistView.addClass( 'open' );
				}
	    	});
	    	
	    	// Show and Hide playlist
	    	jpContentView.click(function(e){
	    	    e.preventDefault();
				if( jpContent.is( ':visible') ) {
					show_hide_content();
					jpContentView.removeClass( 'open' );
				} else {
					show_hide_content(true);
					jpContentView.addClass( 'open' );
				}
	    	});
	    	
			// Show playlist if option is checked in Theme Options
			function playlist_view() {
				if( enable_playlist >= 1 ) {
					jpPlaylistNavContent.show();
				} else {
					jpPlaylistNavContent.hide(); 
				}
			}    	
	    	
	    	// Hide notification messages - Loading & Updated Info
	    	function on_ready() {
	    		jpNotifictions.hide();
				jpNowPlaying.fadeTo( 200, 1 );
				playlist_view();
				update_current_track_info();
				jpPlaylist.removeClass( 'preloading').addClass( 'loaded');
	    	    
	    		if( jpPlaylistNav.is( ':visible') ) {
	    		    jpPlaylistView.addClass( 'open');
	    		} else {
	    		    jpPlaylistView.removeClass( 'open');
	    		}
	    	}
	    	
			// Performed each time a track is played.
			function on_play() {
				update_current_track_info();
				jpCurrentTime.fadeTo( 'fast', 1 );
				thePlayer.addClass( 'playing');
			}
			
			// Performed each time a track is paused.
			function on_pause() {
				jpCurrentTime.fadeTo( 'fast', 0 );
				thePlayer.removeClass( 'playing');
			}
	
	    	// Update current track information
	    	function update_current_track_info() {
	    	    var currentItem   = thePlaylist.playlist[thePlaylist.current];
	    	    var currentTrack  = ( currentItem.title )  ? currentItem.title : '';
	    	    var currentArtist = ( currentItem.artist ) ? currentItem.artist : '';
	    	    var currentAlbum  = ( currentItem.album )  ? currentItem.album : '';
	    	    var currentPoster = ( currentItem.poster ) ? currentItem.poster : '';
	    	    
	    	    jpTrack.html( currentTrack );
	    	    jpArtist.html( currentArtist );
	    	    jpAlbum.html( currentAlbum );
	    	    jpArtwork.attr( 'src', currentPoster );
	    	}
	    	    	
	    	// Add track number
	    	function add_track_number() {
	    		var jpTrackNumber = $('.jp-track-number', thePlayer );
	    	    jpTrackNumber.remove();
	    	    
	    	    $('.tracks li', thePlayer ).each( function() {
	    	    	var trackNumber = $( this ).index() + 1;
	    	    	$( this ).find( 'a.jp-playlist-item').wrapInner( '<span class="jp-track-title" />');
	    	    	$( this ).find( 'a.jp-playlist-item').prepend( '<span class="jp-track-number">' + trackNumber + '.</span>');
	    	    });
	    	}
	    	
	    	function is_widget() {
	    		if ( thePlayer.parent().parent().hasClass('widget') ) {
	    			return 1;
	    		} else {
	    			return 0;
	    		}
	    	}
	    
			// Show and Hide playlist
			function show_hide_playlist(shouldShow) {
				if( 1 == is_widget() ) {
					if(shouldShow) {
						thePlayer.removeClass( 'hide-playlist');
						jpPlaylistNav.fadeIn('fast');
					} else {
						jpPlaylistNav.fadeOut('fast', function() {
							thePlayer.addClass( 'hide-playlist');
						});
        			}
				} else {
					if( shouldShow ) {
						thePlayer.removeClass( 'hide-playlist');
						jpPlaylistNav.slideDown( 'fast' );
					} else {
						jpPlaylistNav.slideUp( 'fast', function() {
							thePlayer.addClass( 'hide-playlist');
						});
					}
				}
			}
			
			// Show and Hide player content
			function show_hide_content( shouldShow ) {
				if( shouldShow ) {
					thePlayer.removeClass( 'hide-content');
					jpContent.slideDown( 'fast' );
				} else {
					jpContent.slideUp( 'fast', function() {
						thePlayer.addClass( 'hide-content');
					});
				}
			}
			
			// Add a class to track list item if it's playable or not
			function highlight_playable_tracks() {				
	    	    $('.tracks li', thePlayer ).each(function() {
	    	    	var indexNumber = $( this ).index();
	    	    	
	    	    	if ( '' != theTracks[indexNumber].mp3 ) {
	    	    		$(this).addClass('playable');
	    	    	} else {
	    	    		$(this).addClass('unplayable');
	    	    	}
	    	    	
	    	    });
			}
			
		});
	}
});

