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
          border-[1px] border-white cursor-pointer">Page Ajouter</div>
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

   

     <div class="grid grid-cols-[3fr_1fr] gap-[40px] min-w-[1020px] max-w-[1200px] m-auto mt-[15px]" >



      <div class="grid grid-cols-[1fr_1fr_1fr_1fr] gap-[10px]">
      
       


         @foreach($lesheures as $lesheure)
   
            @if($lesheure->userid == 0)
              <div>
                     <div  class="bg-[#000077] text-white text-center rounded-[3px] pt-[8px] pb-[8px]"
                     @click="ouvrir1('{{$lesheure->debut}}','{{$lesheure->id}}')" > 
                       {{$lesheure->debut}} 
                     </div>
              </div>
            @endif
   
            @if($lesheure->userid != 0)
              <div>
   
                    <div class="bg-[red] text-white text-center rounded-[3px] pt-[8px] pb-[8px]"
                    @click="ouvrir2('{{$lesheure->debut}}','{{$lesheure->id}}')" >
                       {{$lesheure->debut}}
                    </div>
   
                    <div class="bg-[#000] text-white text-center mt-[2px] pt-[8px] pb-[8px]">
                  
                          <div> 
                          <i wire:confirm="voulez vous retirez ce rendez-vous?" 
                           wire:click="supprimer('{{$lesheure->id}}')" @click="raz()"
                          class="fa fa-trash" aria-hidden="true" style="color:white;font-size:28px;"></i>
                           </div>
                          <div>{{$lesheure->userid}}  </div>
                         <div>{{$lesheure->usernom}}  </div>
                       <div>{{$lesheure->usermail}}  </div>
             
                    </div>
              
              </div>
            @endif
   
         @endforeach
   
         </div>
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
         <div class="livewire-manager-droite">
             
             <div class=" bg-[#000044] text-white rounded-[6px] pl-[10px] pr-[10px] pb-[40px] pt-[20px]" >
                 
                 
                 <template x-if="hour!=''">
                  <div style="text-align : center ; padding-top: 6px ; padding-bottom : 6px;
                   border:1px solid ; border-radius : 3px;">
                   <span x-text="hour"> </span>
                  </div>
                 </template>
   
                  <div>
                  
                  <select name=""  x-model="inputuser"
                    style="width: 100% ; height:42px ;margin-top : 20px ;border : 0px;color:black; ">
                  
                     <option value="">
                        Choisissez un utilisateur
                     </option>
   
                     @foreach($users as $user)
                     <option value="{{$user->id}}">
                     {{$user->id}}  -  {{$user->name}}
                     </option>
                     @endforeach
                  </select>
                  
                  </div>
   
                 
                 <template x-if="open5==true">
                  <div  
                  style="text-align : center ; padding-top: 6px ; padding-bottom : 6px;
                       background-color : blue ; color : white ;margin-top : 20px ;border-radius : 3px;"
                     @click="valider1()">
                      Valider 
                  </div>
                 </template> 
   
               <template x-if="open6==true">
                   <div x-show="open6"
                    style="text-align : center ; padding-top: 6px ; padding-bottom : 6px;
                       background-color : blue ; color : white ;margin-top : 20px ;border-radius : 3px;"
                      @click="changer1()">
                      Changer 
                  </div>
   
                 </template>
               
   
             </div>
   
   

             <div class="bg-[#000044] text-white rounded-[6px] pl-[10px] pr-[10px] pb-[40px] pt-[20px] mt-[15px]">

                <div class="text-black">
                 <input type="text" class="w-full" x-model="inputuser2" placeholder="Entrer un utilisateur"/>
                </div>

                <template x-if="open7==true">
                  <div  
                  style="text-align : center ; padding-top: 6px ; padding-bottom : 6px;
                       background-color : blue ; color : white ;margin-top : 20px ;border-radius : 3px;"
                     @click="valider2()">
                      Valider 
                  </div>
                 </template> 


                 <template x-if="open8==true">
                  <div x-show="open8"
                   style="text-align : center ; padding-top: 6px ; padding-bottom : 6px;
                      background-color : blue ; color : white ;margin-top : 20px ;border-radius : 3px;"
                     @click="changer2()">
                     Changer 
                 </div>
  
                </template>


             </div>
   
             
         
         </div>
   
   
         
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

            inputuser : '' ,
            inputuser2 : '' ,
            ident : '' ,
            hour : '' ,
            open5 : 'false' ,
            open6 : 'false',
            open7 : 'false' ,
            open8 : 'false',

         

            ouvrir1(a,b) {
              this.hour = a ;
             this.ident = b ;
             this.open5 = true ;
             this.open6 = false ;
             this.open7 = true ;
             this.open8 = false ;
            
           },

           ouvrir2(a,b) {
              this.hour = a ;
             this.ident = b ;
              this.open5 = false ;
             this.open6 = true ;
             this.open7 = false ;
             this.open8 = true ;
           },

           raz() {
              this.inputuser = '' ;
              this.inputuser2 = '' ;
             this.hour = '' ;
             this.ident = '' ;
             this.open5 = false ;
             this.open6 = false ;
             this.open7 = false ;
             this.open8 = false ;
           },


            valider1(){
             

              if(this.inputuser == '') {
                Swal.fire({
                   title: 'Error!',
                   text: 'il faut choisir un utilisateur',
                   icon: 'error',
                   confirmButtonText: 'Cool'
                  })
               }
              
               else if (this.inputuser != '') {

                 comp.ajouter1(this.inputuser,this.ident);
                 this.raz();
               }
                 

            },


            valider2() {

               if(this.inputuser2 == '') {
                Swal.fire({
                   title: 'Error!',
                   text: 'il faut choisir un utilisateur',
                   icon: 'error',
                   confirmButtonText: 'Cool'
                  })
               }

               else if (this.inputuser2 != '') {

                  comp.ajouter2(this.inputuser2,this.ident);
                  this.raz();
                   }

            },


             changer1(){
             
               if(this.inputuser == '') {
                Swal.fire({
                   title: 'Error!',
                   text: 'il faut choisir un utilisateur',
                   icon: 'error',
                   confirmButtonText: 'Cool'
                  })
               }

               else if (this.inputuser != ''){

                 @this.modifier1(this.inputuser,this.ident);
                 this.raz();
               }

            },


            changer2() {
               
                if(this.inputuser2 == '') {
                Swal.fire({
                   title: 'Error!',
                   text: 'il faut choisir un utilisateur',
                   icon: 'error',
                   confirmButtonText: 'Cool'
                  })
               }

               else if (this.inputuser2 != ''){

                        @this.modifier2(this.inputuser2,this.ident);
                      this.raz();
                  }

            },
            
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