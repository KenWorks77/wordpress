let favePages = {};
// onLoad
document.addEventListener('DOMContentLoaded', () => {
  const showFaves = document.getElementById('faves');
  const expirationDate = new Date();
  expirationDate.setDate(expirationDate.getDate() + 30);
  if (document.cookie.includes('fave-pages')) {
    getCookieData(showFaves, expirationDate);
  }
  editFavesBtn(showFaves, expirationDate);
  addCookieData(showFaves, expirationDate);
});

// cookieを取得してjson形式に変換 → 結果をfavePagesに格納
function getCookieData (showFaves, expirationDate) {
  let cookieArr = decodeURI(document.cookie).split('; ');
  let faves = cookieArr.filter((value) => {
    return value.includes('fave-pages');
  });
  let data = faves[0].split('=');
  favePages = JSON.parse(data[1]);
  console.log('result: ', favePages);
  if (!showFaves.classList.contains('d-none')) {
    displayFaves(showFaves, expirationDate);
  }
}

// edit favorites button
function editFavesBtn (showFaves, expirationDate) {
  document.getElementById('btn-edit-faves').addEventListener('click', () => {
    if (showFaves.classList.contains('d-none')) {
      showFaves.classList.remove('d-none');
      displayFaves(showFaves, expirationDate);
    } else {
      showFaves.classList.add('d-none');
    }
  });
}

// list表示
function displayFaves (showFaves, expirationDate) {
  const ul = document.getElementById('faves-list');
  if (Object.keys(favePages).length) {
    let keys = Object.keys(favePages);
    ul.innerHTML = '';
    keys.forEach((key) => {
      ul.innerHTML += '<li><a href="' + favePages[key].url + '"><p><img src="' + favePages[key].img + '">' + favePages[key].title + '</p></a> <button class="remove" data-slug="' + favePages[key].slug + '">×</button></li>';
    });
    removeCookieData(showFaves, expirationDate);
  } else {
    ul.innerHTML = '<li class="default-li">No favorite pages</li>';
  }
}

// 削除ボタンを押して該当pageを削除
function removeCookieData (showFaves, expirationDate) {
  let removeBtns = document.querySelectorAll('.remove');
  removeBtns.forEach((button) => {
    button.addEventListener('click', () => {
      let cookieData = {};
      delete favePages[button.dataset.slug];
      cookieData = JSON.stringify(favePages);
      cookieData = encodeURI(cookieData.toString());
      document.cookie = 'fave-pages=' + cookieData + '; expires=' + expirationDate.toUTCString() + '; path=/wp/; Secure';
      getCookieData(showFaves, expirationDate);
    })
  });
}

// 追加ボタンを押してcookie登録
function addCookieData (showFaves, expirationDate) {
  const addBtnArr = document.querySelectorAll('.add-favorite');
  addBtnArr.forEach((targetBtn) => {
    targetBtn.addEventListener('click', () => {
      let cookieData = {};
      let current_post = {};
      current_post.slug = targetBtn.dataset.slug;
      current_post.title = targetBtn.dataset.title;
      current_post.url = targetBtn.dataset.url;
      current_post.img = targetBtn.dataset.img;
      cookieData[current_post.slug] = current_post;
      if (favePages) {
        cookieData = Object.assign(cookieData, favePages);
      }
      cookieData = JSON.stringify(cookieData);
      cookieData = encodeURI(cookieData.toString());
      document.cookie = 'fave-pages=' + cookieData + '; expires=' + expirationDate.toUTCString() + '; path=/wp/; Secure';
      getCookieData(showFaves, expirationDate);
    });
  });
}
