function traitement() {
  var xhr2 = new XMLHttpRequest();
  xhr2.open("POST", "import.php", true);
  xhr2.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log("xhr2 : " + this.responseText);
      document.getElementById("progressText").innerHTML = this.responseText;
      document.getElementById("upload").style.display = "none";
    }
  };
  xhr2.send("");
}
function onSubmit() {
  var file = document.getElementById("file").files[0];
  var formData = new FormData();
  formData.append("file", file);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "upload.php", true);
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log("xhr : " + this.responseText);
      document.getElementById("progressText").innerHTML = this.responseText;
      setTimeout(traitement, 1500);
      console.log("xhr2 : Traitement en cours...");
      document.getElementById("progressText").innerHTML =
        "Traitement en cours...";
    }
  };
  xhr.upload.onprogress = function (e) {
    var percentComplete = Math.ceil((e.loaded / e.total) * 100);
    document.getElementById("progressText").innerHTML =
      "Upload du fichier en cours...";
    document.getElementById("progressBar").value = percentComplete;
    console.log(
      "Charges=" +
        e.loaded +
        " | Total=" +
        e.total +
        " | Complete=" +
        percentComplete
    );
  };
  xhr.send(formData);
  return false;
}
