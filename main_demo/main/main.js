function addLicense() {
    window.location.href = '../regist_license/regist_license.php';
}

function removeLicense(li_id) {
    if(confirm("本当に削除しますか？")){
        window.location.href = 'delete.php?license='+li_id;
    }
}

function showDetail(li_id){
    window.location.href = 'l_detail.php?license='+li_id;
}