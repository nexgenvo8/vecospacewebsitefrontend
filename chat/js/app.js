// replace these values with those generated in your TokBox Account
var apiKey = "45958552";
var sessionId = "1_MX40NTk1ODU1Mn5-MTUwNTMxNTUzNzAxMn5TY0RkclVxUnE5MXpCUG4yb0ZYUm8rdDd-fg";
var token = "T1==cGFydG5lcl9pZD00NTk1ODU1MiZzaWc9NjFjYjk5YTYxNzMyOTVhNmUzZTViYjMzMmQwZjc4ZTI4OTkwOTk4MzpzZXNzaW9uX2lkPTFfTVg0ME5UazFPRFUxTW41LU1UVXdOVE14TlRVek56QXhNbjVUWTBSa2NsVnhVbkU1TVhwQ1VHNHliMFpZVW04cmREZC1mZyZjcmVhdGVfdGltZT0xNTA1MzE1NTY4Jm5vbmNlPTAuODg1NzkwMDUzOTgzMjkzMiZyb2xlPW1vZGVyYXRvciZleHBpcmVfdGltZT0xNTA1MzE5MTY1JmluaXRpYWxfbGF5b3V0X2NsYXNzX2xpc3Q9";

// Handling all of our errors here by alerting them
function handleError(error) {
  if (error) {
    alert(error.message);
  }
}

// (optional) add server code here
initializeSession();

function initializeSession() {
  var session = OT.initSession(apiKey, sessionId);

  // Subscribe to a newly created stream
  session.on('streamCreated', function(event) {
    session.subscribe(event.stream, 'subscriber', {
      insertMode: 'append',
      width: '100%',
      height: '100%'
    }, handleError);
  });

  // Create a publisher
  var publisher = OT.initPublisher('publisher', {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  }, handleError);

  // Connect to the session
  session.connect(token, function(error) {
    // If the connection is successful, initialize a publisher and publish to the session
    if (error) {
      handleError(error);
    } else {
      session.publish(publisher, handleError);
    }
  });
}