function editLicense(li_id) {
    window.location.href = 'edit_license.php?license='+li_id;
}

function showDetail(li_id){
    window.location.href = 'l_detail.php?license='+li_id;
}

function deleteRequest(req_id){
    window.location.href = 'delete_req.php?request='+req_id;
}