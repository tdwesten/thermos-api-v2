var https = require("follow-redirects").https;

console.log("Thermos Daemon is now running");

setTimeout(function () {
  var options = {
    method: "POST",
    hostname: "api.thermos.test",
    path: "/api/v1/heartbeats/-actions/status-update",
    headers: {
      "Content-Type": "application/vnd.api+json",
      Accept: "application/vnd.api+json",
    },
    maxRedirects: 20,
  };

  var req = https.request(options, function (res) {
    var chunks = [];

    res.on("data", function (chunk) {
      chunks.push(chunk);
    });

    res.on("end", function (chunk) {
      var body = Buffer.concat(chunks);
      console.log(body.toString());
    });

    res.on("error", function (error) {
      console.error(error);
    });
  });

  var postData = JSON.stringify({
    thermostat_id: "07382c60-26a3-4c33-9943-7daa2cef676b",
    temperature: 19,
    is_heating: false,
  });

  req.write(postData);

  req.end();
}, 1000);
