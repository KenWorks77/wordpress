// edit favorites
function favorites () {
  let favePages = {};
  if (document.cookie.includes('fave-pages')) {
    getCookieData();
  }
  addCookieData();
  editFavesBtn();

  // cookieを取得してjson形式に変換 → 結果を表示
  function getCookieData () {
    let cookieArr = decodeURI(document.cookie).split('; ');
    let faves = cookieArr.filter((value) => {
      return value.includes('fave-pages');
    });
    let data = faves[0].split('=');
    favePages = JSON.parse(data[1]);
    displayFaves();
    removeCookieData();
  }

  // 追加ボタンを押してcookie登録
  function addCookieData () {
    const addBtn = document.getElementById('add-favorite');
    addBtn.addEventListener('click', () => {
      let cookieData = {};
      cookieData[current_post.slug] = current_post;
      if (favePages) {
        cookieData = Object.assign(cookieData, favePages);
      }
      cookieData = JSON.stringify(cookieData);
      cookieData = encodeURI(cookieData.toString());
      document.cookie = 'fave-pages=' + cookieData;
      getCookieData();
    });
  }

  // 削除ボタンを押して該当pageを削除
  function removeCookieData () {
    let removeBtns = document.querySelectorAll('.remove');
    removeBtns.forEach((button) => {
      button.addEventListener('click', () => {
        let cookieData = {};
        delete favePages[button.dataset.slug];
        cookieData = JSON.stringify(favePages);
        cookieData = encodeURI(cookieData.toString());
        document.cookie = 'fave-pages=' + cookieData;
        getCookieData();
        })
    });
  }

  // list表示
  function displayFaves () {
    const ul = document.getElementById('faves-list');
    if (Object.keys(favePages).length) {
      let keys = Object.keys(favePages);
      ul.innerHTML = '';
      keys.forEach((key) => {
        let imgSrc = favePages[key].thumbnail_img ? favePages[key].thumbnail_img : favePages[key].first_img;
        ul.innerHTML += '<li><a href="' + favePages[key].url + '"><p><img src="' + imgSrc + '">' + favePages[key].title + '</p></a> <button class="remove" data-slug="' + favePages[key].slug + '">×</button></li>';
      });
    } else {
      ul.innerHTML = '<li class="default-li">No favorite pages</li>';
    }
  }
}

// edit favorites button
function editFavesBtn () {
  const btn = document.getElementById('btn-edit-faves');
  const target = document.getElementById('faves');
  btn.addEventListener('click', () => {
    target.classList.toggle('d-none');
  });
}
