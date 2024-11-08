let lastScrollTop = 0;

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  let currentScrollTop = document.documentElement.scrollTop || document.body.scrollTop;
  
  if (currentScrollTop > lastScrollTop && currentScrollTop > 20) {
    
    document.getElementById("navbar").style.top = "-60px";
  } else if (currentScrollTop < lastScrollTop) {
 
    document.getElementById("navbar").style.top = "0";
  }
  
  lastScrollTop = currentScrollTop;
}

// Show more and less
function toggleTags() {
  const hiddenTags = document.querySelectorAll('.hidden-tag');
  const button = document.getElementById('toggle-tags');

  if (button.innerText === "Show More") {
      hiddenTags.forEach(tag => {
          tag.style.display = 'flex';
      });
      button.innerText = "Show Less";
  } else {
      hiddenTags.forEach(tag => {
          tag.style.display = 'none';
      });
      button.innerText = "Show More";
  }
}

// Upload
function uploadImage() {
  document.getElementById('wallpaper').click();
}

function uploadprofile() {
  document.getElementById('profile').click();
}

// Preview Image
function previewImage(event) {
  const image = document.getElementById('preview');
  image.src = URL.createObjectURL(event.target.files[0]);
  image.style.display = 'block';
}


// Download wallpaper
const downloadLinks = document.querySelectorAll('.download-btn');

downloadLinks.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        
        const imageUrl = this.getAttribute('href'); 
        
        const a = document.createElement('a');
        a.href = imageUrl;
        a.download = imageUrl.split('/').pop();
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });
});

function selectTag(tagId) {
  document.getElementById('selectedTag').value = tagId;
  document.getElementById('tagForm').submit();
}
document.querySelectorAll('.tag').forEach(tag => {
tag.addEventListener('click', function() {
  document.getElementById('selectedTag').value = this.id;
  document.getElementById('tagForm').submit();
});
});

document.querySelectorAll(".fav-btn").forEach(button => {
  button.addEventListener("click", function() {
    const wallpaperId = this.getAttribute("data-id");
    if (wallpaperId) {
      fetch("favorite.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id=" + wallpaperId
      })
      .then(response => response.text())
      .then(data => {
        if (data === "success") {
          alert("Wallpaper has been added to favorites.");
        } else {
          alert("Failed to add wallpaper to favorites.");
        }
      })
      .catch(error => console.error("Error:", error));
    } else {
      alert("Please log in to favorite wallpapers.");
    }
  });
});

const keyword = document.getElementById('keyword');
var searchServices = document.getElementById('user-table');
if (searchServices == null){
  var searchServices = document.getElementById('wallpaper-table');
}
keyword.addEventListener('keyup', function() {
  if (keyword.value === '') {
    if (searchServices) {
      searchServices.innerHTML = ''; 
    }
  } else {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
        if (searchServices) {
          searchServices.innerHTML = xhr.responseText;
        }
      }
    };
    if (searchServices.id == 'user-table'){
    xhr.open('GET', '../element/showuser.php?keyword=' + keyword.value, true);
    xhr.send();
    }else{
      xhr.open('GET', '../element/showwallpaper.php?keyword=' + keyword.value, true);
      xhr.send();
    }
  }
});