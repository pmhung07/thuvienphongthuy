<script>
   function delete_package(id){
      var id = id;
      $.ajax({
         type:'POST',
         dataType:'json',
         data:{id:id},
         url:'delete_pack.php',
         success:function(data){
            alert("X�a th�nh c�ng");  
            window.location.reload();
         }
      });
   }
</script>