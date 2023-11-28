function doSubmit() {
  const elForm = document.getElementById("form");
  const elTa = document.getElementById("ta");
  const elRes = document.getElementById("res-submit");
  let jstr = "";
  try {
    jstr = JSON.stringify(JSON.parse(elTa.value));
    fetch(elForm.action, {
      method: "POST",
      mode: "cors", // no-cors, *cors, same-origin
      cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
      credentials: "same-origin", // include, *same-origin, omit
      headers: {
        "Content-Type": "application/json",
        // 'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: "follow", // manual, *follow, error
      referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
      body: jstr, // body data type must match "Content-Type" header
    })
      .then((data) => data.json())
      .then((jdata) => {
        elRes.innerHTML = `<pre id="res">${JSON.stringify(
          jdata,
          null,
          2
        )}</pre>`;
      })
      .catch((err) => {
        elRes.innerHTML = `<pre id="err">${err}</pre>`;
      });
  } catch (err) {
    elRes.innerHTML = `<pre id="err">${err}</pre>`;
  }
  return false;
}

function retrieve() {
  const elRes = document.getElementById("res-retrieve");
  fetch("short/?uuid=2db9cd01-e909-448d-8883-93e2773657a7", {
    method: "GET",
    mode: "cors", // no-cors, *cors, same-origin
    cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
    credentials: "same-origin", // include, *same-origin, omit
    redirect: "follow", // manual, *follow, error
    referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
  })
    .then((data) => {
      try {
        return data.json();
      } catch (err) {
        elRes.innerHTML = `<pre id="err">${err}</pre>`;
      }
    })
    .then((jdata) => {
      elRes.innerHTML = `<pre id="res">${JSON.stringify(jdata, null, 2)}</pre>`;
    })
    .catch((err) => {
      elRes.innerHTML = `<pre id="err">${err}</pre>`;
    });
  return false;
}

addEventListener("load", (event) => {
  const elButton = document.getElementById("retrieve");
  elButton.addEventListener("click", retrieve);
});
