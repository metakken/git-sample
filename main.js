let i = 1

function addLicense() {
    // 5人以上なら処理を終了する
    if (i > 4) {
        return true;

    } else {
        // 複製するHTML要素を取得
        const element = document.getElementById("main_target");

        // 要素を複製
        const newelement = element.cloneNode(true);

        //親要素を取得し 複製した要素を追加
        const parent = document.getElementById("target");
        parent.appendChild(newelement);

       //インデント番号を更新
        i++;

        count();
    }
}

function removeLicense() {
    // 1人以上なら処理を終了する
    if (i < 2) {
        return true;

    } else {
        const parent_r = document.getElementById("main_target");
        parent_r.parentNode.removeChild(parent_r);

       //インデント番号を更新
        i--;

        count();
    }
}

//保有資格総数表示
function count() {
    document.getElementById('edit_area').innerHTML = i;
}


function detailmenu(){
    // 要素を取得
    let ele = document.getElementById("detailmenu");
    // 現在の display プロパティの値を保持
    const displayOriginal = ele.style.display;
    if(displayOriginal=='none'){
        // 元に戻して表示
        ele.style.display = 'inline';
    }else{
        // none に設定して非表示
        ele.style.display = 'none';
    }

}


