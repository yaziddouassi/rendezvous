<div class="flex w-full " x-data="rdvadd(@this)">
   
    @livewire('rendezvous.sidebarre')

    <div class=" w-full max-w-[1150px]  overflow-x-auto  pr-[10px] pl-[10px] ">




      <div class="flex gap-[10px] bg-[black] p-[5px]">

        <div class="rounded-[25px] min-w-[280px] max-w-[280px] mt-[5px]">
            <input type="text" class="h-[50px] rounded-[25px] border-[2px] border-black "
            wire:model.live.debounce.1200ms="search" @click="ouvrir()" placeholder="Search...">

            <button class="bg-[blue] text-white p-[6px] pr-[8px] pl-[8px] rounded-[4px]"
           wire:click="searchrezet()">
                <i class="fa fa-times text-[24px]"></i>
            </button>
          

        </div>
        <div class="w-full mt-[10px]">  {{ $users->links('rendezvous::pagination.rendezvous') }} </div>
      </div>

         
       <div class="p-[10px] bg-[#eee] mt-[10px] rounded-[5px]" x-show="open">
           
         <div class="text-right pb-[10px]"> <button class="bg-[blue] text-white p-[8px] rounded-[4px] 
            " @click="fermer()">FERMER</button> 
         </div>
         <div class="grid grid-cols-4">
            @foreach ($users as $user)
       
              <div class="text-center">
                <div>{{$user->id}} -  {{$user->email}} </div>
                <div>{{$user->name}}  </div>
                <div>{{$user->name}}  </div>
              </div> 
       
            @endforeach 
        </div>
       </div>

     @teleport('#monid3')
       <div class="mb-[20px] text-center font-bold">{{$journee}}</div>
     @endteleport

     @teleport('#monid4')
     <div class="mb-[20px] text-center font-bold bg-[darkblue] rounded-[2px]
         text-center pt-[8px] pb-[8px]
          border-[1px] border-white cursor-pointer">Page Mois</div>
     @endteleport

     @teleport('#monid2')
     <div class="grid grid-cols-2 gap-[5px]">
      <div class="bg-[black] mt-[10px] text-white text-center p-[8px] font-bold
   border-[1px] border-white rounded-[4px] mb-[10px]" @click="ouvrir()">AFFICHER</div>
   <div class="bg-[blue] mt-[10px] text-white text-center p-[8px] font-bold
   border-[1px] border-white rounded-[4px] mb-[10px]" @click="fermer()">FERMER</div>

    </div>
    @endteleport

    @teleport('#monid5')
    <div></div>
   @endteleport

     
     @teleport('#monid')
     <div>
        <div class="grid grid-cols-4 text-[14px] gap-[3px] mb-[8px]">
            <div class="bg-[darkblue] rounded-[2px] text-center pt-[4px] pb-[4px]
            border-[1px] border-white cursor-pointer" @click="rediriger('horaire')">Heure</div>
            <div  class="bg-[blue] rounded-[2px] text-center pt-[4px] pb-[4px]
           border-[1px] border-white cursor-pointer" @click="rediriger('ajouter')">Ajout.</div>
            <div  class="bg-[red] rounded-[2px] text-center pt-[4px] pb-[4px]
            border-[1px] border-white cursor-pointer" @click="rediriger('supprimer')">Supp.</div>
            <div  class="bg-[green] rounded-[2px] text-center pt-[4px] pb-[4px]
            border-[1px] border-white cursor-pointer" @click="rediriger('mois')">Mois</div>
        </div>
        <div>
            <input type="date" @change="changedate()" x-model="inputdate" class="w-full text-black">
        </div>
        
     </div> 
     @endteleport


     <div class="grid grid-cols-[1fr_1fr_1fr_1fr] gap-[40px] min-w-[1020px] max-w-[1200px] m-auto mt-[15px]">

      @foreach($lesjours as $lesjour)
          <div>
      
              <div class="bg-[#000044] text-white text-center pt-[8px] pb-[8px]">
                  {{$lesjour->journee}}
              </div>
      
            
                  
              <div class="bg-[#000] text-white text-center pt-[20px] pb-[20px] pr-[10px] pl-[10px] mt-[5px]
              grid grid-cols-[1fr_1fr_1fr] gap-x-[5px] gap-y-[10px]">
      
              @foreach($reserves as $reserve)
                @if($lesjour->jour == $reserve->jour)
                  <div style="background-color: blue ; color : white ;
                  text-align:center;padding-top: 3px ; padding-bottom : 3px;">
                    {{$reserve->debut}}
                  </div>
                  @endif 
               @endforeach 
              </div>
                 
               
          </div>
      
          @endforeach
      
      </div>




    </div>
</div>


@script
<script>
    Alpine.data('rdvadd', (comp) => {
        return {
            open: false,
            madate : comp.entangle('madate'),
            inputdate : null,
            inputdate2 : null,
            
            init() {
                this.inputdate = this.madate
              
               this.formaterdate()
               this.formaterdate2()
            },  

            fermer() {
                this.open = false ;
            },

            ouvrir() {
                this.open = true ;
            },

            changedate() {
                this.formaterdate()
               this.formaterdate2()
            },

            formaterdate() {
            var ladate2 = this.inputdate.split('-').map(Number);
            var ladate = [];

            ladate[0] = ladate2[0];
            ladate[1] = ladate2[1];
            ladate[2] = ladate2[2];


             if(ladate[1] == '1') {

                ladate[1] = '01'
             }

             if(ladate[1] == '2') {

                ladate[1] = '02'
             }

             if(ladate[1] == '3') {

                ladate[1] = '03'
             }

             if(ladate[1] == '4') {

                ladate[1] = '04'
             }

             if(ladate[1] == '5') {

                ladate[1] = '05'
             }

             if(ladate[1] == '6') {

                ladate[1] = '06'
             }

             if(ladate[1] == '7') {

                ladate[1] = '07'
             }

             if(ladate[1] == '8') {

                ladate[1] = '08'
             }

              if(ladate[1] == '9') {

                ladate[1] = '09'
             }




             if(ladate[2] == '1') {

                ladate[2] = '01'
             }

             if(ladate[2] == '2') {

                ladate[2] = '02'
             }

             if(ladate[2] == '3') {

                ladate[2] = '03'
             }

             if(ladate[2] == '4') {

                ladate[2] = '04'
             }

             if(ladate[2] == '5') {

                ladate[2] = '05'
             }

             if(ladate[2] == '6') {

                ladate[2] = '06'
             }

             if(ladate[2] == '7') {

                ladate[2] = '07'
             }

             if(ladate[2] == '8') {

                ladate[2] = '08'
             }

              if(ladate[2] == '9') {

                ladate[2] = '09'
             }


             this.inputdate = ladate.join('-') ;
            console.log(this.inputdate)
 
            },

            formaterdate2() {
            var ladate2 = this.inputdate.split('-').map(Number);
            var ladate = [];

            ladate[0] = ladate2[0];
            ladate[1] = ladate2[1];
            ladate[2] = ladate2[2];


             if(ladate[1] == '01') {

                ladate[1] = '1'
             }

             if(ladate[1] == '02') {

                ladate[1] = '2'
             }

             if(ladate[1] == '03') {

                ladate[1] = '3'
             }

             if(ladate[1] == '04') {

                ladate[1] = '4'
             }

             if(ladate[1] == '05') {

                ladate[1] = '5'
             }

             if(ladate[1] == '06') {

                ladate[1] = '6'
             }

             if(ladate[1] == '07') {

                ladate[1] = '7'
             }

             if(ladate[1] == '08') {

                ladate[1] = '8'
             }

              if(ladate[1] == '09') {

                ladate[1] = '9'
             }




             if(ladate[2] == '01') {

                ladate[2] = '1'
             }

             if(ladate[2] == '02') {

                ladate[2] = '2'
             }
          
             if(ladate[2] == '03') {

                ladate[2] = '3'
             }
           
             if(ladate[2] == '04') {

                ladate[2] = '4'
             }
          
             if(ladate[2] == '05') {

                ladate[2] = '5'
             }
            
             if(ladate[2] == '06') {

                ladate[2] = '6'
             }
             
             if(ladate[2] == '07') {

                ladate[2] = '7'
             }
           
             if(ladate[2] == '08') {

                ladate[2] = '8'
             }
            
              if(ladate[2] == '09') {

                ladate[2] = '9'
             }
              

             this.inputdate2 = ladate.join('-') ;
            console.log(this.inputdate2)
 
            },

            rediriger(a) {

                if(this.inputdate == '0--') {
                     return alert('choisissez une date')
                }
                var params = new URLSearchParams(window.location.search)
                var page = params.get('page'); 
                var search = params.get('search');
                var url = '/admin/rdv/' + this.inputdate2 + '/' + a

                


                if(page != null && search == null) {
                    url = '/admin/rdv/' + this.inputdate2 + '/' + a + '?page=' + page
                }

                if(page == null && search != null) {
                    url = '/admin/rdv/' + this.inputdate2 + '/' + a + '?search=' + search
                }

                if(page != null && search != null) {
                    url = '/admin/rdv/' + this.inputdate2 + '/' + a + '?search=' + search + '&page=' + page
                }
                   

                Livewire.navigate(url)  
           }
            
        }
    })
</script>
@endscript
