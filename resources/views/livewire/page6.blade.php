<div class="pt-[50px]  min-h-[100vh]">
    <div class="text-center font-bold">
        MES RENDEZ-VOUS
    </div>

    <div class="max-w-[400px] m-auto mt-[10px]  p-[5px]">
       @foreach ($this->lesheures as $item)
           <div>
           - {{$item->journee}}
           </div>
       @endforeach
    </div>
</div>