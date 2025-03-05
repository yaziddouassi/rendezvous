<div class="max-w-[400px]  m-auto pt-[15px] pb-[15px] pr-[5px] pl-[5px] ">
    
    <div class="livewire-myrendezvous-haut">
          
          
     

         @foreach($lesjours as $lesjour)

            

           @livewire('rendezvous.petitrdv',
                    ['ladate' => $lesjour->ladate,
                        'journee' => $lesjour->journee,
                         'annee' => $lesjour->annee ,
                         'mois' => $lesjour->mois ,
                         'jour' => $lesjour->jour],
              key($lesjour->id) )

          @endforeach

    </div>

    <div x-data ="{ouvirir : ''}"
      wire:click="ajouter()"
         @click="$dispatch('toggle')"
     class="max-w-[200px] pt-[12px] pb-[12px] bg-[blue] text-center text-white rounded-[3px] m-auto mt-[40px]">
             AFFICHER &nbsp; PLUS
    </div>


  



    <style>



.livewire-myrendezvous-haut {
   
    gap : 10px ;
}

.livewire-myrendezvous-haut-div1 {
   margin-bottom : 15px;
}

.livewire-myrendezvous-haut-div1-journee {
    border : 1px solid white ;
    text-align : center ;
    color : white ;
    padding-top : 7px ;
    padding-bottom : 7px ;
    border-radius : 2px ;
}

.livewire-myrendezvous-haut-div1-horaire {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-gap : 5px ;
    text-align : center ;
    padding-top : 5px ;
    padding-bottom : 5px;
}

.livewire-myrendezvous-haut-div1-horaire-debut {
    border : 1px solid white ;
    color : white ;
    border-radius : 4px ;
    padding-top : 3px ;
    padding-bottom : 3px ;
}






</style>

   

</div>

