<template>            

  <form method="POST" action="/resposta" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group" v-bind:class="{  'has-error': form.errors.has('texto') }">
            <label for="texto"  >Texto da Pergunta:</label>
            <textarea id="texto" name="texto" class="form-control input" v-model="form.texto" style="height:150px"> </textarea>
            <span class="help is-danger" v-if="form.errors.has('texto')" v-text="form.errors.get('texto')"></span>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div   class="form-group" >
            <h4><label  for="correta" style="display: block;" >pergunta:</label></h4>
            <select v-model="form.correta" id="correta" class="form-control " name="correta" required style="width: 100%"> 
              <option  value="true">Sim</option>   
              <option  value="false" selected >Não</option>
            </select>                                 
          </div>
        </div>

        <div class="col-md-12">

          <div class="form-group"  >
            <h4><label  for="pergunta_id" style="display: block;" >Pergunta:</label></h4>
            <select2 :options="pergunta" v-model="form.pergunta_id" class="form-control produto_id_select">
              <option    value="">Selecione a Pergunta </option> 
              <option v-for="item in pergunta" :key="item.id" :value="item.id"> {{ item.texto }}</option> 

            </select2> 
          </div>

        </div>
      </div>
    </div>

    <div class="box-footer align-right"> 
      <button  style="margin-left: 5px;" class="btn btn-success"   :disabled="form.errors.any()">Cadastrar</button>
    </div>
  </form>

</template>










<script>


import Form from '../../core/Form';

export default {
   
    props:[
    'pergunta'
    ],

    data() {
        return {                
               form: new Form({
                    texto: '',   
                    pergunta_id: '', 
                    correta:'false' ,            
               })
            }
        },

        

        methods: {
            
            onSubmit() {
                this.form.post('/resposta')
                    .then(response =>
                      swal({
                               
                              type: 'success',
                              showCloseButton: true,
                              title: 'Resposta Cadastrada com sucesso!!',
                              timer: 5000,
                              width: 400,
                               
                              confirmButtonColor: '#646464',
                              confirmButtonText: '<h4>OK</h4>',
                              confirmButtonClass: 'bg-green',

                            })
                      )
                    .catch(errors => console.log(errors));
            }

        }
        
    }


    
</script>
