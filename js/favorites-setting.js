let favePages = {};
// onLoad
document.addEventListener('DOMContentLoaded', () => {
  const showFaves = document.getElementById('faves');
  const addBtnArr = document.querySelectorAll('.add-favorite');
  const expirationDate = new Date();
  expirationDate.setDate(expirationDate.getDate() + 180);
  if (document.cookie.includes('fave-pages')) {
    getCookieData(showFaves, expirationDate, addBtnArr);
  }
  editFavesBtn(showFaves, expirationDate, addBtnArr);
  addCookieData(showFaves, expirationDate, addBtnArr);
});

// cookieを取得してjson形式に変換 → 結果をfavePagesに格納
function getCookieData(showFaves, expirationDate, addBtnArr) {
  let cookieArr = decodeURI(document.cookie).split('; ');
  let faves = cookieArr.filter((value) => {
    return value.includes('fave-pages');
  });
  let data = faves[0].split('=');
  favePages = JSON.parse(data[1]);
  if (!showFaves.classList.contains('d-none')) {
    displayFaves(showFaves, expirationDate, addBtnArr);
  }
  checkBtnStatus(addBtnArr);
}

// edit favorites button
function editFavesBtn(showFaves, expirationDate, addBtnArr) {
  document.getElementById('btn-edit-faves').addEventListener('click', () => {
    if (showFaves.classList.contains('d-none')) {
      showFaves.classList.remove('d-none');
      displayFaves(showFaves, expirationDate, addBtnArr);
    } else {
      showFaves.classList.add('d-none');
    }
  });
}

// list表示
function displayFaves(showFaves, expirationDate, addBtnArr) {
  const ul = document.getElementById('faves-list');
  if (Object.keys(favePages).length) {
    let keys = Object.keys(favePages);
    ul.innerHTML = '';
    keys.forEach((key) => {
      ul.innerHTML += '<li><a href="' + favePages[key].url + '"><p><img src="' + favePages[key].img + '">' + favePages[key].title + '</p></a> <button class="remove" data-slug="' + favePages[key].slug + '">×</button></li>';
    });
    removeCookieData(showFaves, expirationDate, addBtnArr);
  } else {
    ul.innerHTML = '<li class="default-li">No favorite pages</li>';
  }
}

// 削除ボタンを押して該当pageを削除
function removeCookieData(showFaves, expirationDate, addBtnArr) {
  let removeBtns = document.querySelectorAll('.remove');
  removeBtns.forEach((button) => {
    button.addEventListener('click', () => {
      let cookieData = {};
      delete favePages[button.dataset.slug];
      cookieData = JSON.stringify(favePages);
      cookieData = encodeURI(cookieData.toString());
      document.cookie = 'fave-pages=' + cookieData + '; expires=' + expirationDate.toUTCString() + '; path=/wp/; Secure';
      getCookieData(showFaves, expirationDate, addBtnArr);
    })
  });
}

// 追加ボタンを押してcookie登録
function addCookieData(showFaves, expirationDate, addBtnArr) {
  addBtnArr.forEach((targetBtn) => {
    targetBtn.addEventListener('click', () => {
      let cookieData = {};
      let currentPost = {};
      currentPost.slug = targetBtn.dataset.slug;
      currentPost.title = targetBtn.dataset.title;
      currentPost.url = targetBtn.dataset.url;
      currentPost.img = targetBtn.dataset.img;
      cookieData[currentPost.slug] = currentPost;
      if (favePages) {
        cookieData = Object.assign(cookieData, favePages);
      }
      cookieData = JSON.stringify(cookieData);
      cookieData = encodeURI(cookieData.toString());
      document.cookie = 'fave-pages=' + cookieData + '; expires=' + expirationDate.toUTCString() + '; path=/wp/; Secure';
      getCookieData(showFaves, expirationDate, addBtnArr);
    });
  });
}

// check button status
function checkBtnStatus(addBtnArr) {
  addBtnArr.forEach((targetBtn) => {
    if (Object.keys(favePages).length) {
      let keysArr = Object.keys(favePages);
      targetBtn.innerHTML = 'Add to favorites';
      targetBtn.disabled = false;
      keysArr.forEach((key) => {
        if (key === targetBtn.dataset.slug) {
          targetBtn.innerHTML = 'Added to favorites';
          targetBtn.disabled = true;
        }
      });
    } else {
      targetBtn.innerHTML = 'Add to favorites';
      targetBtn.disabled = false;
    }
  });
}
