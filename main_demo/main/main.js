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

function showAllDetail(li_id){
    window.location.href = 'a_detail.php?license='+li_id;
}

function addTerm(li_id,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10) {
    window.location.href = 'add_term.php?license='+li_id+'&term1='+t1+'&term2='+t2+'&term3='+t3+'&term4='+t4+'&term5='+t5+'&term6='+t6+'&term7='+t7+'&term8='+t8+'&term9='+t9+'&term10='+t10;
}

function changeFlag(li_id,a_flag){
    let b_check1 = document.getElementById('checkbig1');
    let b_check2 = document.getElementById('checkbig2');
    let s_check1 = document.getElementById('checksmall1');
    let s_check2 = document.getElementById('checksmall2');
    let s_check3 = document.getElementById('checksmall3');
    let s_check4 = document.getElementById('checksmall4');
    let s_check5 = document.getElementById('checksmall5');
    let s_check6 = document.getElementById('checksmall6');
    let s_check7 = document.getElementById('checksmall7');
    let s_check8 = document.getElementById('checksmall8');
    let s_check9 = document.getElementById('checksmall9');
    let s_check10 = document.getElementById('checksmall10');
    window.location.href = 'change_flag.php?license='+li_id+'&achieve_flag='+a_flag+'&bcheck_flag1='+b_check1.checked+'&bcheck_flag2='+b_check2.checked+'&scheck_flag1='+s_check1.checked+'&scheck_flag2='+s_check2.checked+'&scheck_flag3='+s_check3.checked+'&scheck_flag4='+s_check4.checked+'&scheck_flag5='+s_check5.checked+'&scheck_flag6='+s_check6.checked+'&scheck_flag7='+s_check7.checked+'&scheck_flag7='+s_check8.checked+'&scheck_flag9='+s_check9.checked+'&scheck_flag10='+s_check10.checked;
}

function changeText(li_id,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10){
    let s_check1 = document.getElementById('text1');
    let s_check2 = document.getElementById('text2');
    let s_check3 = document.getElementById('text3');
    let s_check4 = document.getElementById('text4');
    let s_check5 = document.getElementById('text5');
    let s_check6 = document.getElementById('text6');
    let s_check7 = document.getElementById('text7');
    let s_check8 = document.getElementById('text8');
    let s_check9 = document.getElementById('text9');
    let s_check10 = document.getElementById('text10');
    window.location.href = 'change_text.php?license='+li_id+'&scheck_flag1='+s_check1.value+'&scheck_flag2='+s_check2.value+'&scheck_flag3='+s_check3.value+'&scheck_flag4='+s_check4.value+'&scheck_flag5='+s_check5.value+'&scheck_flag6='+s_check6.value+'&scheck_flag7='+s_check7.value+'&scheck_flag7='+s_check8.value+'&scheck_flag9='+s_check9.value+'&scheck_flag10='+s_check10.value+'&term1='+t1+'&term2='+t2+'&term3='+t3+'&term4='+t4+'&term5='+t5+'&term6='+t6+'&term7='+t7+'&term8='+t8+'&term9='+t9+'&term10='+t10;
}

function deleteTerm(id,li_id,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10){
    console.log(id);
    window.location.href = 'delete_term.php?license='+li_id+'&button_flag='+id+'&term1='+t1+'&term2='+t2+'&term3='+t3+'&term4='+t4+'&term5='+t5+'&term6='+t6+'&term7='+t7+'&term8='+t8+'&term9='+t9+'&term10='+t10;
}
function deleteTerm1(id,li_id){
    console.log(id);
    console.log(li_id);
}
