<template>
  <div class="posts">
    <div class="col-md-6">
      <button
        @click="openModal()"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3"
      >
        Adicionar Novo
      </button>
      <table class="table-fixed w-full">
        <thead>
          <tr>
            <th class="px-4 py-2 w-20">Titulo</th>
            <th class="px-4 py-2">autor</th>
            <th class="px-4 py-2">corpo</th>
            <th class="px-4 py-2">Action</th>
          </tr>
        </thead>
        <tr v-for="(post, id) in data" :key="id">
          <td class="border px-4 py-2">{{ post.titulo }}</td>
          <td class="border px-4 py-2">{{ post.autor }}</td>
          <td class="border px-4 py-2">{{ truncateText(post.corpo) }}</td>
          <td class="border px-4 py-2">
            <button @click="edit(post)" class="btn btn-sm btn-primary">
              Editar
            </button>
            <button @click="deleteRow(post)" class="btn btn-sm btn-danger">
              Del
            </button>
          </td>
        </tr>
      </table>
      <div
        class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400"
        v-if="isOpen"
      >
        <div
          class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        >
          <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>
          <!-- This element is to trick the browser into centering the modal contents. -->
          <span
            class="hidden sm:inline-block sm:align-middle sm:h-screen"
          ></span
          >​
          <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog"
            aria-modal="true"
            aria-labelledby="modal-headline"
          >
            <form>
              <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="">
                  <div class="mb-4">
                    <label
                      for="autor"
                      class="block text-gray-700 text-sm font-bold mb-2"
                      >Autor:</label
                    >
                    <input
                      type="text"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="autor"
                      placeholder="Entre com o  Autor"
                      v-model="form.autor"
                    />
                    
                  </div>
                  <div class="mb-4">
                    <label
                      for="titulo"
                      class="block text-gray-700 text-sm font-bold mb-2"
                      >Titulo:</label
                    >
                    <input
                      type="text"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="titulo"
                      placeholder="Entre com o Titulo"
                      v-model="form.titulo"
                    />
                    
                  </div>

                  <div class="mb-4">
                    <label
                      for="corpo"
                      class="block text-gray-700 text-sm font-bold mb-2"
                      >Corpo:</label
                    >
                    <textarea
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="corpo"
                      v-model="form.corpo"
                      placeholder="Entre com corpo do post"
                    ></textarea>
                    
                  </div>
                </div>
              </div>
              <div
                class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
              >
                <span
                  class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto"
                >
                  <button
                    wire:click.prevent="store()"
                    type="button"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                    v-show="!editMode"
                    @click="save(form)"
                  >
                    Salvar
                  </button>
                </span>
                <span
                  class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto"
                >
                  <button
                    wire:click.prevent="store()"
                    type="button"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                    v-show="editMode"
                    @click="update(form)"
                  >
                    Atualizar
                  </button>
                </span>
                <span
                  class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto"
                >
                  <button
                    @click="closeModal()"
                    type="button"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                  >
                    Cancelar
                  </button>
                </span>
              </div>
            </form>
        

      
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </div>
  </div>
</template>

<script>
export default {
   props : [ 'data' , 'erros' ],  
  data() {
    return {
      editMode: false,
      isOpen: false,
      form: {
        titulo:'',
        corpo:'',
        autor:'',
      },
    };
  },
  methods: {
    truncateText(text) {
      if (text.length > 24) {
        return `${text.substr(0, 24)}...`;
      }
      return text;
    },
    openModal: function () {
      this.isOpen = true;
    },
    closeModal: function () {
      this.isOpen = false;
      this.reset();
      this.editMode = false;
    },
    reset: function () {
      this.form = {
        title: null,
        body: null,
        autor: null,
      };
    },
    save: function (data) {
      this.$inertia.post("/posts", data);
      this.reset();
      this.closeModal();
      this.editMode = false;
    },
    edit: function (data) {
      this.form = Object.assign({}, data);
      this.editMode = true;
      this.openModal();
    },
    update: function (data) {
      data._method = "PUT";
      this.$inertia.post("/posts/" + data.id, data);
      this.reset();
      this.closeModal();
    },
    deleteRow: function (data) {
      if (!confirm("Are you sure want to remove?")) return;
      data._method = "DELETE";
      this.$inertia.post("/posts/" + data.id, data);
      this.reset();
      this.closeModal();
    },
  },
};
</script>
<style scoped>
.posts {
  margin-left: 200px;
  margin-top: 100px;
}
</style>