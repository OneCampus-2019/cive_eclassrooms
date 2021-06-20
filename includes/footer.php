<!-- blocks of js -->
<!-- this is for 2rd modal -->
<script>
$(document).ready(function(){
    
    $(document).on('click', '#getPdf', function(e){
        
        e.preventDefault();
        
        var uid = $(this).data('id');   // it will get id of clicked row
        
        $('#dynamic-contentpdf').html(''); // leave it blank before ajax call
        $('#modal-loader').show();      // load ajax loader
        
        $.ajax({
            url: '../instructor/pdfing.php',
            type: 'POST',
            data: 'id='+uid,
            dataType: 'html'
        })
        .done(function(data){
            console.log(data);  
            $('#dynamic-contentpdf').html('');    
            $('#dynamic-contentpdf').html(data); // load response 
            $('#modal-loader').hide();        // hide ajax loader   
        })
        .fail(function(){
            $('#dynamic-contentpdf').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            $('#modal-loader').hide();
        });
        
    });
    
});

</script>
<!-- end of blocks of js -->
<!-- this is for modal -->
<script>
$(document).ready(function(){
    
    $(document).on('click', '#getHist', function(e){
        
        e.preventDefault();
        
        var uid = $(this).data('id');   // it will get id of clicked row
        
        $('#dynamic-contentHist').html(''); // leave it blank before ajax call
        $('#modal-loader').show();      // load ajax loader
        
        $.ajax({
            url: 'hist.php',
            type: 'POST',
            data: 'id='+uid,
            dataType: 'html'
        })
        .done(function(data){
            console.log(data);  
            $('#dynamic-contentHist').html('');    
            $('#dynamic-contentHist').html(data); // load response 
            $('#modal-loader').hide();        // hide ajax loader   
        })
        .fail(function(){
            $('#dynamic-contentHist').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            $('#modal-loader').hide();
        });
        
    });
    
});

</script>
<!-- end modal -->
<!-- this is for 2nd modal -->
<script>
$(document).ready(function(){
    
    $(document).on('click', '#getJibu', function(e){
        
        e.preventDefault();
        
        var uid = $(this).data('id');   // it will get id of clicked row
        
        $('#dynamic-contentjibu').html(''); // leave it blank before ajax call
        $('#modal-loader').show();      // load ajax loader
        
        $.ajax({
            url: 'jibu.php',
            type: 'POST',
            data: 'id='+uid,
            dataType: 'html'
        })
        .done(function(data){
            console.log(data);  
            $('#dynamic-contentjibu').html('');    
            $('#dynamic-contentjibu').html(data); // load response 
            $('#modal-loader').hide();        // hide ajax loader   
        })
        .fail(function(){
            $('#dynamic-contentjibu').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            $('#modal-loader').hide();
        });
        
    });
    
});

</script>
<!-- end 2nd modal -->
<script>
$(document).ready(function(){
    
    $(document).on('click', '#getNoti', function(e){
        
        e.preventDefault();
        
        var uid = $(this).data('id');   // it will get id of clicked row
        
        $('#dynamic-contentNotif').html(''); // leave it blank before ajax call
        $('#modal-loader').show();      // load ajax loader
        
        $.ajax({
            url: '../student/notif.php',
            type: 'POST',
            data: 'id='+uid,
            dataType: 'html'
        })
        .done(function(data){
            console.log(data);  
            $('#dynamic-contentNotif').html('');    
            $('#dynamic-contentNotif').html(data); // load response 
            $('#modal-loader').hide();        // hide ajax loader   
        })
        .fail(function(){
            $('#dynamic-contentNotif').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            $('#modal-loader').hide();
        });
        
    });
    
});

</script>
<!-- this is for quiz modal -->
<script>
$(document).ready(function(){
    
    $(document).on('click', '#getQuiz', function(e){
        
        e.preventDefault();
        
        var uid = $(this).data('id');   // it will get id of clicked row
        
        $('#dynamic-contentQuiz').html(''); // leave it blank before ajax call
        $('#modal-loader').show();      // load ajax loader
        
        $.ajax({
            url: '../student/quizing.php',
            type: 'POST',
            data: 'qid='+uid,
            dataType: 'html'
        })
        .done(function(data){
            console.log(data);  
            $('#dynamic-contentQuiz').html('');    
            $('#dynamic-contentQuiz').html(data); // load response 
            $('#modal-loader').hide();        // hide ajax loader   
        })
        .fail(function(){
            $('#dynamic-contentQuiz').html('<i class="glyphicon glyphicon-info-sign"></i> YEs Something went wrong, Please try again...');
            $('#modal-loader').hide();
        });
        
    });
    
});

</script>
<!-- end quiz modal -->
                </main>
                <footer class="py-4 bg-light mt-auto" style="margin-bottom: -5px ">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; CIVE <?php  echo date('Y'); ?></div>
                            <div class="text-muted pull-right">Version 1.6.5</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
       
       
        <script src="../assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../assets/js/scripts.js"></script>
       <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
        <!-- <script src="dist/assets/demo/chart-area-demo.js"></script>
        <script src="dist/assets/demo/chart-bar-demo.js"></script> -->
          <script src="../assets/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="../assets/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <!-- <script src="../assets/demo/datatables-demo.js"></script> -->
<!-- <script src="../assets/dist/js/bootstrap-select.min.js"></script> -->
        <!-- sweet alert -->
    
        <!-- end added from header -->
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
            <script src="../assets/js/sweetalert.min.js"></script>
        <script src="../dist/assets/demo/datatables-demo.js"></script>
        <script src="../assets/sweetalert2/sweetalert2.min.js"></script>
         <script type="text/javascript" src="../assets/js/validation.js"></script>
         <script type="text/javascript" src="../assets/js/accordion.js"></script>
         <script type="text/javascript" src="../assets/js/jquery.table2excel.js"></script>
	<script type="text/javascript" src="../assets/select2/js/select2.full.min.js"></script>

        <script type="text/javascript">
            $(function () {
              $('[data-toggle="tooltip"]').tooltip();
               })
        </script>

    </body>
</html>
