const ajaxStartEvent = new CustomEvent('ajaxStart');
const ajaxEndEvent = new CustomEvent('ajaxEnd');

function dispatchLoading()
{
    document.dispatchEvent(ajaxStartEvent);
}

function dispatchLoaded()
{
    document.dispatchEvent(ajaxEndEvent);
}

window.dispatchLoading = dispatchLoading;
window.dispatchLoaded = dispatchLoaded;