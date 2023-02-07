const uploadForm = document.querySelector("#upload-form");
const submitBtn = document.querySelector("#submit-btn");

uploadForm.addEventListener("submit", async (event) => {
  event.preventDefault();

  submitBtn.innerHTML = `<i>Processing...</i>`;
  submitBtn.setAttribute("disabled", "");

  const formData = new FormData(uploadForm);

  const request = new Request("http://data-transformer.local/process.php", {
    method: "POST",
    body: formData,
  });

  const response = await fetch(request);
  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`);
  }
  const responseJson = await response.json();

  if (responseJson) {
    uploadForm.reset();
    submitBtn.innerHTML = `Process`;
    submitBtn.removeAttribute("disabled");

    if (responseJson.success === false) {
      console.error(responseJson.errors);
    } else {
      console.log(responseJson);
    }
  }

  event.preventDefault();
});
