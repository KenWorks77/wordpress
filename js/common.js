// resize window
let currentWindow;
let resizeWindow;
// onLoad
document.addEventListener('DOMContentLoaded', () => {
  currentWindow = window.innerWidth;
  resizeWindow = currentWindow;
  getImgSize();
  selectRedirect();
});
// onResize
window.addEventListener('resize', () => {
  resizeWindow = window.innerWidth;
  if (currentWindow != resizeWindow) {
    // fade-inで0.5秒時間差があるので
    window.setTimeout(getImgSize, 500);
    currentWindow = resizeWindow;
  }
});
// adjust images
function getImgSize () {
  let adjustImgs = document.querySelectorAll('.adjust-img');
  adjustImgs.forEach((target) => {
    target.style.height = Math.trunc(target.clientWidth * 0.75) + 'px';
  });
}

// fade-in
let fadeInTarget = document.querySelectorAll('.fade-in');
const options = {
  root: null, 
  rootMargin: "0px 0px", 
  threshold: 0.2
};
// fadeInTargetが交差するかどうか調べるAPI(Intersection Observer)
const observer = new IntersectionObserver(doWhenIntersect, options);
fadeInTarget.forEach((element) => {
    observer.observe(element);
  }
);
// 交差していることが判明したらclass="active"追加
function doWhenIntersect(entries) {
  // console.log(entries);
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add("active");
    }
  });
}

// scroll to top
const scrollTop = document.querySelector('#scroll-top a');
scrollTop.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});

// pagination
const pagination = document.querySelector('ul.page-numbers');
if (pagination) {
  let firstLi = pagination.firstElementChild.firstChild.className;
  let lastLi = pagination.lastElementChild.firstChild.className;
  if (firstLi.indexOf('prev') == -1) {
    let prevNode = document.createElement('li');
    prevNode.innerHTML = '<span class="page-numbers none">« Prev</span>';
    pagination.prepend(prevNode);
  }
  if (lastLi.indexOf('next') == -1) {
    let nextNode = document.createElement('li');
    nextNode.innerHTML = '<span class="page-numbers none">Next »</span>';
    pagination.append(nextNode);
  }
}

// selectRedirect
function selectRedirect () {
  const selectBox = document.querySelector('#selectbox');
  selectBox.addEventListener('change', (event) => {
    let value = event.target.value;
    if (value !== '') {location.href = value;}
  });
}
