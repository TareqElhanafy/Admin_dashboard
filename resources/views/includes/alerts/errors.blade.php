@if(session('error'))
      <!-- begin alet section-->
      <div class="row mr-2 ml-2">
        <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2" id="type-error">
            {{session('error')}}
   </button>
    </div>
    <!-- end alet section-->
@endif
