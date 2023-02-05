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
  const data = await response.json();
  console.log(data);
});
