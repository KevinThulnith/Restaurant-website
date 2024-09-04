//navbar configuration
document.getElementById("user").addEventListener("click", () => {
  document.getElementById("userbar").classList.add("active");
});

document.getElementById("asd").addEventListener("click", () => {
  document.getElementById("userbar").classList.remove("active");
});

// add buttons to food items
document.querySelectorAll(".menus").forEach((fd) => {
  let btt = document.createElement("button");
  btt.innerHTML = "<i class='fa-solid fa-angles-up'>";
  fd.appendChild(btt);
  btt.addEventListener("click", () => {
    document.querySelector(".contrt").querySelector("h1").innerHTML =
      fd.querySelector("h3").innerHTML;
    document.querySelector(".contrt").querySelector("h3").innerHTML =
      fd.querySelector(".price").innerHTML;
    document.querySelector(".contrt").querySelector("p").innerHTML =
      fd.querySelector("p").innerHTML;
    let rt = document.querySelector(".contrt").querySelector(".image");
    let tr = fd.querySelector(".img");
    rt.style.backgroundImage = tr.style.backgroundImage;
    document.querySelector(".contrt").classList.remove("hide");
  });
});

document.querySelector(".xmark").addEventListener("click", () => {
  document.querySelector(".contrt").classList.add("hide");
});

// upload image
let imageInput = "";

document.getElementById("uimagetag").addEventListener("change", function () {
  const render = new FileReader();
  render.addEventListener("load", () => {
    imageInput = render.result;
    document.getElementById("uimage").style.backgroundImage =
      "url(" + imageInput + ")";
  });
  render.readAsDataURL(this.files[0]);
});
