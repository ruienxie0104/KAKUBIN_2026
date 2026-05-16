<?php
require('./config.php');
require('./ky_function.php');
require('./member_session.php');
header("Content-Type:text/html;charset=utf-8");
$acttype='member';
$actno=(isset($_GET["actno"]))?intval($_GET["actno"]):''; // 活動
$tag=(isset($_GET["backtag"]))?intval($_GET["backtag"]):'';

// if(isset($_SESSION["agree"])&&!empty($_SESSION["agree"])){
// }else{
//   echo '<script>window.location.href="agree.php?actno='.$actno.'";</script>';exit;
// }
if(isset($_SESSION["id"])&&!empty($_SESSION["id"])){
  $member_no=ky_select_member_no($_SESSION["id"]);
  if(!empty($member_no)){
    echo '<script>window.location.href="game.php?actno='.$actno.'";</script>';exit;
  }else{
    echo '<script>window.location.href="index.php?actno='.$actno.'";</script>';exit;
  }
}

$_SESSION['member_token']=hash('sha256',uniqid('member_'));
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>三得利－角瓶月見祭</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+TC:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-P3FQV4SV');</script>
  <!-- End Google Tag Manager -->
</head>
  <style>
    .agreement-container {
      margin: 25% auto 10%;
      width: 95%;
      border-radius: 15px;
      background-color: rgba(255, 255, 255, 0.95);
      color: #333;
      padding: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
      border: 2px solid #ff6b6b;
    }
    
    .agreement-title {
      text-align: center;
      color: #0f3460;
      margin-bottom: 15px;
      font-weight: 700;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    .agreement-content {
      margin-bottom: 15px;
      line-height: 1.6;
    }
    
    .agreement-section {
      margin-top: 20px;
      margin-bottom: 15px;
    }
    
    .agreement-list {
      padding-left: 20px;
      margin-bottom: 15px;
    }
    
    .agreement-list li {
      margin-bottom: 10px;
    }
    
    .agree-btn {
      background: linear-gradient(45deg, #ff6b6b, #ffd93d);
      border: none;
      padding: 15px 40px;
      border-radius: 50px;
      font-size: 18px;
      font-weight: bold;
      color: #fff;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 8px 15px rgba(255, 107, 107, 0.3);
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
      width: 60%;
      display: none;
    }
    
    .agree-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 25px rgba(255, 107, 107, 0.4);
    }
    
    .agree-btn-disabled {
      background: #d3d3d3;
      border: none;
      padding: 15px 40px;
      border-radius: 50px;
      font-size: 18px;
      font-weight: bold;
      color: #888;
      cursor: not-allowed;
      width: 60%;
      box-shadow: none;
      text-shadow: none;
    }
  </style>
<style>
  .register-form {
    background-color: rgba(15, 52, 96, 0.85);
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    margin-top: 30px;
    max-width: 360px;
    margin-left: auto;
    margin-right: auto;
  }
  
  .register-form h3 {
    color: #ffd93d;
    text-align: center;
    margin-bottom: 25px;
    font-size: 24px;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    font-weight: 700;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #fff;
    font-size: 16px;
  }
  
  .form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid rgba(255, 217, 61, 0.5);
    border-radius: 8px;
    background-color: rgba(255, 255, 255, 0.9);
    color: #16213e;
    font-size: 16px;
    transition: all 0.3s ease;
  }
  
  .form-group input:focus {
    border-color: #ffd93d;
    box-shadow: 0 0 10px rgba(255, 217, 61, 0.5);
    outline: none;
  }
  
  .save-btn {
    background: linear-gradient(45deg, #ff6b6b, #ffd93d);
    border: none;
    padding: 15px 40px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: bold;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 8px 15px rgba(255, 107, 107, 0.3);
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    width: 100%;
    display: block;
    margin: 30px auto 0;
  }
  
  .save-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(255, 107, 107, 0.4);
  }
  
  .footer {
    margin-top: 30px;
    text-align: center;
  }
  
  .footer img {
    max-width: 100%;
  }
</style>
<body class="result-body" style="background-repeat:repeat-y;">
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P3FQV4SV"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <div class="container" style="margin-bottom: 30%;">
    <div class="agreement-container">
      <h2 class="agreement-title">三得利全球烈酒公司</h2>
      <h3 class="agreement-title">理性飲酒同意書及個人肖像權拍攝影片著作權</h3>
      <p class="agreement-content">非常感謝您的蒞臨,「角瓶月見祭」現場提供活動限定酒水,主辦單位為推廣理性飲酒、友善提醒您,請不要飲酒過量並遵守以下理性飲酒重點，謝謝。</p>
      
      <h3 class="agreement-section">理性飲酒同意</h3>
      <ul class="agreement-list">
        <li>依台灣法令規定,我年滿法定喝酒年齡 <strong>18</strong> 歲,如主辦單位有疑慮,我願出示身分證證明文件。</li>
        <li>尊重生命,理性飲酒,我不會在飲酒後自行開車或騎車。</li>
        <li>有心臟、高血壓疾病的來賓及懷孕的婦女,請勿飲酒。飲酒前以及飲酒時候建議請先進食,提醒勿空腹飲酒避免傷身。</li>
        <li>不得有酒醉而影響會場秩序與安全之行為,酒醉與否由主辦單位認定之。</li>
        <li>我已充分閱讀、了解本 <strong>[理性飲酒同意書及個人肖像權拍攝影片著作權]</strong> 所載之個人資料蒐集、處理及利用告知事項,並同意貴公司蒐集、處理及利用本人之個人資料。</li>
      </ul>
      
      <h3 class="agreement-section">資料保護</h3>
      <p class="agreement-content">本人茲同意於此提供「角瓶月見祭」活動(以下簡稱本活動)之資料得由三得利全球烈酒公司以及其委託之服務提供商利用、處理及使用。</p>
      
      <h3 class="agreement-section">個人肖像權及拍攝影片著作權</h3>
      <p class="agreement-content">本人同意於本活動中出現之本人肖像影片和照片攝影，相關人格權及智慧財產權(包括但不限於著作權)將由三得利全球烈酒公司所有，並同意由三得利全球烈酒公司以及其委託之服務提供商發行及傳播。本人拋棄就拍攝影像之創作、銷售或出版請求任何報酬之權利。此亦適用於為本人自身目的使用或利用，該拍攝影片及/或照片請求報酬之權利。</p>
      
      <p class="agreement-content">在此同意遵守以上規範參與活動,若因隱瞞而造成自身損傷,本人願自負全責,一切責任與主辦單位無關。</p>
      <p class="agreement-content">本人確已詳閱以上說明並簽署以示同意。</p>
      <p class="agreement-content">主辦單位:三得利全球烈酒公司</p>
      
    </div>

    <form id="register" class="register-form">
      <h3>非常感謝您的配合</h3>
      <div class="form-group">
        <div>
          <input type="text" name="name" id="name" placeholder="請輸入姓名" data-msg-required="請輸入姓名" required>
        </div>
      </div>
      <div class="form-group">
        <div>
          <input type="text" name="alternate1" id="alternate1" placeholder="身分證後四碼" data-msg-required="身分證後四碼" maxlength="4" pattern="[0-9]{4}" title="請輸入4位數字" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 4)" required>
        </div>
      </div>
      <div>
        <button id="save" class="save-btn" type="button">同意及送出</button>
      </div>
    </form>
  </div>
  
  <footer class="footer">
    <img src="images/footer.jpg" alt="">
  </footer>
  
</body>
<?php require '_js.php' ?>
<script>
  let a='';
  const actno='<?php echo ($actno)??''; ?>';
  a=(!!actno)? ('?actno='+actno) :'';
  // $('#name').focus();
  $('#save').on('click',(e)=>{
    let form=document.getElementById("register");
    if (!form.checkValidity()) {
      e.preventDefault(); // 阻止送出
      form.reportValidity(); // 觸發瀏覽器內建提示
    } else {
      let post={};
      post['name'] = ($('input[name="name"]').val()) ? $('input[name="name"]').val(): '';
      post['alternate1'] = ($('input[name="alternate1"]').val()) ? $('input[name="alternate1"]').val(): '';
      saveData(post);
    }
  });

  function saveData(obj={}){
    Swal.fire({
      title: '忙碌中，請稍等。',
      html: '',
      onBeforeOpen: () => {
        Swal.showLoading();
        $.ajax({
          url: 'script/register-api-save.php?fn=save_member',
          type: 'post',
          fake: true, // fake ajax
          data: Qs.stringify(obj),
          dataType: 'json',
          headers: {
            Accept: "application/json; charset=utf-8",
            Authtoken:"<?php echo ($_SESSION['member_token'])??''; ?>",
          },
          error: function(xhr) {
            console.log(xhr);
            Swal.fire('請檢查資料是否正確。');
            Swal.hideLoading();
          },
          success: function(response) {
            console.log(response);
            let msg=response.msg?response.msg:'';
            if(response.success==true){
              // Swal.fire({
              //   position: 'center',
              //   icon: 'success',
              //   title: msg,
              //   showConfirmButton: false,
              //   timer: 1500
              // }).then((result) => {
              //   Swal.close();
              //   window.location.replace('game.php'+a);
              // });
              // Swal.hideLoading();
              window.location.replace('game.php'+a);
            }else{
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: msg,
                showConfirmButton: true
              });
            }
          },
        });
      },
      onClose: () => {},
      allowOutsideClick: () => !Swal.isLoading(),
    });

  }


</script>

</html>