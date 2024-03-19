document.getElementById('copy-button').addEventListener('click', function() {
    var urlField = document.getElementById('page-url');
    var range = document.createRange();
    range.selectNode(urlField);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();
    // Disable button and change text to "Copied"
    var copyButton = document.getElementById('copy-button');
    copyButton.disabled = true;
    copyButton.innerHTML = 'Copied!';
});