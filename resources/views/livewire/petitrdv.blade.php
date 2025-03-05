<div   x-data="livewire_petitrdvous(@this)"
          class="livewire-myrendezvous-haut-div1">
                  
                  <div  @click="toggle()"
                  class="livewire-myrendezvous-haut-div1-journee">
                       {{$journee}}
                  </div>

                  <div  X-show="open"
                  class="livewire-myrendezvous-haut-div1-horaire">
                  
 
                        @if($lesheures != '')

                         @foreach ($lesheures  as $lesheure)
                             
                         <div wire:click="valider('{{$lesheure->id}}')"
                         class="livewire-myrendezvous-haut-div1-horaire-debut">
                         
                                {{$lesheure->debut}}
                         
                         </div> 
                            
                        @endforeach 

                        @endif

                  </div>


        @script
        <script>
           
            
                Alpine.data('livewire_petitrdvous', (comp) => {
                    return {
             open: false,

             init() {

              
             },

             toggle() {
                 this.open = !this.open ;
             },
 
            }
        }) 
               
        
      </script>
      @endscript

     </div>


