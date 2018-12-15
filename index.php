<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Aplikasi Cek Resi</title>
  <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
</head>
<body>
 <form id="myForm" method="post">
  <label>============= Dari : =============</label><br>
  <label for="Provinsi">Provinsi</label> :
   <select name="provinsi" id="provinsi">
     <option value="0">Pilih Provinsi</option>
   </select><br>
   <label for="Kabupaten/Kota">Kabupaten/Kota</label> :
   <select name="city" id="city">
     <option value="0">Pilih Kabupaten/Kota</option>
   </select><br><br>
   <label>============= Ke : =============</label><br>
   <label for="Provinsi"> Provinsi</label> :
   <select name="provinsi2" id="provinsi2">
     <option value="0">Pilih Provinsi</option>
   </select><br>
   <label for="Kabupaten/Kota">Kabupaten/Kota</label> :
   <select name="city2" id="city2">
     <option value="0">Pilih Kabupaten/Kota</option>
   </select><br><br>
    <label>============= Berat : =============</label><br>
   <label for="Berat">Berat</label> :
   <input type="number" name="berat" value="1" required> KG<br><br>
   <input type="submit" id="submit" value="Cek Ongkir">
 </form>
 <div id="ongkir"></div>

 <script>
  function getProvinsi(){
  // mengirim dan mengambil data Provinsi
        $.ajax({
            url: "getProvinsi.php",
            success: function(data){
                // jika tidak ada data
                if(data == ''){
                    alert('Ada Yang error');
                }
                // jika dapat mengambil data, tampilkan di combo box Provinsi
                else{
                    $("#provinsi").html(data);                                                     
                    $("#provinsi2").html(data);                                                     
                    getCity(1);
                    getCity(2);
                }
            }
        });
}
function getCity(cek)
{
  var provinsi_id
  if(cek == 1){
    provinsi_id = $("#provinsi").val();
  }else{
    provinsi_id = $("#provinsi2").val();
  }
  
  $.ajax({
              type: "POST",
              dataType: "html",
              url: "getCity.php",
              data: "prov="+provinsi_id,
              success: function(data){
                  // jika tidak ada data
                  if(data == ''){
                      alert('Ada Yang error');
                  }
                  // jika dapat mengambil data, tampilkan di combo box kota
                  else{
                      if(cek == 1){
                          $("#city").html(data);
                      }else{
                          $("#city2").html(data);
                      }
                    
                  }
                    
                }
            
        });

}


$( document ).ready(function() {
        getProvinsi();
        $("#provinsi").change(function(){
            getCity(1);
        });
        $("#provinsi2").change(function(){
            getCity(2);
        });
        $('#myForm').submit(function(e){
          $('#submit').val('-- Process --');
          $("#submit").prop('disabled', true);
          e.preventDefault();
            $.ajax({
            type: "POST",
            dataType: "html",
            url: "getOngkir.php",
            data: $('#myForm').serialize(),
            success: function(data){
                // jika tidak ada data
                if(data == ''){
                    alert('Ada Yang error');
                }
                // jika dapat mengambil data, tampilkan Detail Ongkir JNE
                else{
                    $("#ongkir").html(data);
                    $('#submit').val('Cek Ongkir');
                    $("#submit").prop('disabled', false);
                }
            }
        });

          });

});
</script> 
</body>
</html>