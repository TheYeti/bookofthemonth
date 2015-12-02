function makeRequest() {

}
function init() {
    gapi.client.setApiKey(apikey);
    gapi.client.load('books', 'v1').then(makeRequest);
}

