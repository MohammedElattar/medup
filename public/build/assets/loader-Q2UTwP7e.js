const t=new CustomEvent("ajaxStart"),n=new CustomEvent("ajaxEnd");function a(){document.dispatchEvent(t)}function d(){document.dispatchEvent(n)}window.dispatchLoading=a;window.dispatchLoaded=d;
