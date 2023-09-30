<template>
    <div class="d-flex align-items-center">
        <div class="form-floating mb-3 me-3">
            <input type="number" class="form-control" placeholder="CantidadParaagregar" v-model="cantidadAgregar">
            <label for="floatingInput">Cantidad a Agregar</label>
        </div>

        <button @click="CantidadAgregar()" type="button" class="btn me-3">Agregar</button>

        <button @click="Guardar()" class="btn ms-auto"><i class="mdi mdi-content-save me-0" style="color: white; font-size: 30px;"></i></button>
    </div>

    <div class="row">
            <div v-for="campo in Acampos" :key="campo" class="col-6">
                <div :class="{'card': true, 'card-ahorro': campo.ahorro, 'card-gasto': campo.gasto}">
                    <h1 class="editTitulo">{{ campo.nombre }}</h1>
                    <h3 class="editTitulo">{{ campo.porcentaje }}%</h3>
                    <h4 class="editTitulo" v-if="mostrarResultado">C. Previa: ${{ campo.resultadoPrevio }}</h4>
                    <h4 class="editTitulo">C. Acumulada: ${{ campo.resultadoAcumulado }}</h4>
                    <footer>
                        <button @click="EditarTarjeta(campo)" type="button" class="btn btn-success btn-footer float-end" data-bs-toggle="modal" data-bs-target="#miModal">
                            <i class="mdi mdi-pencil-box-outline"></i>
                        </button>
                        <button @click="DeleteDialog(campo.id)" type="button" class="btn btn-danger btn-footer float-end">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </footer>
                </div>
            </div>
        </div>

    <button type="button" class="btn btn-margen btn-cuadrangular position-fixed bottom-0 end-0"
    data-bs-toggle="modal" data-bs-target="#miModal">
    <i class="mdi mdi-plus-box-outline"></i>
    </button>



    <div class="modal fade" id="miModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Datos de los Cards para control de ahorro</h5>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="form-floating mb-3">
                            <input v-model="tarjetaSeleccionada.nombre" type="text" class="form-control" placeholder="CantidadParaagregar" id="nombreInput">
                            <label for="nombreInput">Nombre del campo</label>
                            <div v-if="!tarjetaSeleccionada.nombre" class="invalid-feedback">
                                Nombre es obligatorio.
                            </div>
                            <div v-if="tarjetaSeleccionada.nombre" class="valid-feedback">
                                Es Correcto, pero no funciono este mensaje
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-floating mb-3">
                            <input v-model="tarjetaSeleccionada.porcentaje" type="number" class="form-control" placeholder="CantidadParaagregar" id="porcentajeInput">
                            <label for="porcentajeInput">Porcentaje destinado</label>
                            <div v-if="!tarjetaSeleccionada.porcentaje" class="invalid-feedback">
                                Porcentaje es obligatorio.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-floating mb-3">
                            <input v-model="tarjetaSeleccionada.descripcion" class="form-control" type="text" placeholder="Descripcion" required id="descripcionInput" >
                            <label for="descripcionInput">Descripcion</label>
                            <div v-if="!tarjetaSeleccionada.descripcion" class="invalid-feedback">
                                descripcion es obligatorio.
                            </div>
                        </div>
                    </div>

                    <div class="form-check">
                        <input v-model="tarjetaSeleccionada.ahorro" class="form-check-input" type="checkbox" id="checkboxAhorro" required>
                        <label for="checkboxAhorro">Ahorro</label>
                    </div>

                    <div class="form-check">
                        <input v-model="tarjetaSeleccionada.gasto" class="form-check-input" type="checkbox" id="checkboxGasto" required >
                        <label for="checkboxGasto">Gasto</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="CancelarDialog()" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                    <button @click="GuardarDialog()" type="button" class="btn btn-primary" >Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
import 'mdi/css/materialdesignicons.min.css';

export default {
    data(){
        return{
            tarjetaSeleccionada:{
                id:null,
                nombre:'',
                porcentaje: 0,
                ahorro: false,
                gasto:false,
                descripcion:'',

            },
            resultadoAcumulado: 0,
            cantidadAgregar: 0,
            mostrarResultado: false,
            Acampos:[]
        }
    },
    mounted(){
        this.getDialog()
    },

    methods: {
        Guardar() {
            const actualizaciones = this.Acampos.map(campo => ({
                id: campo.id,
                resultadoAcumulado: campo.resultadoAcumulado
            }));

            axios
                .post('/api/ahorros/actualizar-resultado-acumulado', { actualizaciones })
                .then(response => {
                    console.log('Campos resultadoAcumulado actualizados correctamente');
                })
                .catch(error => {
                    console.error('Error al actualizar campos resultadoAcumulado', error);
                });
        },


        GuardarDialog() {

            if (!this.tarjetaSeleccionada.nombre) {
                // Agrega la clase 'is-invalid' al campo correspondiente
                document.getElementById('nombreInput').classList.add('is-invalid');
                return; // Detiene la ejecución si hay errores de validación
            }
            //else if(!this.tarjetaSeleccionada.porcentaje){
            //     document.getElementById('porcentajeInput').classList.add('is-invalid');
            // }
            else if(!this.tarjetaSeleccionada.descripcion){
                document.getElementById('descripcionInput').classList.add('is-invalid');
            }
            else{
                // Crear un objeto con los datos que quieres enviar
                const data = {
                    nombre: this.tarjetaSeleccionada.nombre,
                    porcentaje: this.tarjetaSeleccionada.porcentaje,
                    ahorro: this.tarjetaSeleccionada.ahorro,
                    gasto: this.tarjetaSeleccionada.gasto,
                    descripcion: this.tarjetaSeleccionada.descripcion,
                    //resultadoAcumulado: this.tarjetaSeleccionada.resultadoAcumulado  // Incluye resultadoAcumulado

                };

                if (this.tarjetaSeleccionada.id) {
                    // Si ya tienes una id, es una actualización (PUT)
                    axios
                    .put(`/api/ahorros/${this.tarjetaSeleccionada.id}`, data)
                    .then(response => {
                        console.log('Tarjeta actualizada correctamente');
                        this.CancelarDialog();
                        this.getDialog();
                    })
                    .catch(error => {
                        console.error('Error al actualizar la tarjeta', error);
                    });
                } else {
                    // Si no tienes una id, es una creación (POST)
                    axios
                    .post('/api/ahorros', data)
                    .then(response => {
                        console.log('Tarjeta creada correctamente');
                        this.CancelarDialog();
                        this.getDialog();
                    })
                    .catch(error => {
                        console.error('Error al crear la tarjeta', error);
                    });
                }
            }
        },

        DeleteDialog(id) {
        axios
            .delete(`/api/ahorros/${id}`)
            .then(response => {
            console.log('Tarjeta eliminada correctamente');
            // Aquí puedes actualizar tu vista para reflejar el cambio
            // Por ejemplo, podrías eliminar la tarjeta de tu lista de tarjetas
            this.Acampos = this.Acampos.filter(campo => campo.id !== id);
            })
            .catch(error => {
            console.error('Error al eliminar la tarjeta', error);
            });
        },


        getDialog(){
            axios.get('/api/ahorros')
            .then(response => {
                this.Acampos = response.data;
                console.log(this.Acampos,'Mis datos');
            })
        },


        CancelarDialog(){
            this.tarjetaSeleccionada.id = null;
            this.tarjetaSeleccionada.ahorro = false;
            this.tarjetaSeleccionada.gasto = false;
            this.tarjetaSeleccionada.nombre = '';
            this.tarjetaSeleccionada.porcentaje = 0;
            this.tarjetaSeleccionada.descripcion = '';
        },


        CantidadAgregar() {
            const cantidad = parseFloat(this.cantidadAgregar);

            if (!isNaN(cantidad)) {
                this.mostrarResultado = true;
                this.Acampos.forEach(campo => {
                    campo.resultadoPrevio = ((campo.porcentaje / 100) * cantidad).toFixed(2);
                    if(!campo.resultadoAcumulado){
                        campo.resultadoAcumulado = ((campo.porcentaje / 100) * cantidad).toFixed(2);
                    }else{
                        campo.resultadoAcumulado = (parseFloat(campo.resultadoPrevio) + parseFloat(campo.resultadoAcumulado)).toFixed(2);
                    }

                });
            }
        },


        EditarTarjeta(tarjeta) {
            this.tarjetaSeleccionada = {
                id: tarjeta.id,
                nombre: tarjeta.nombre,
                porcentaje: tarjeta.porcentaje,
                ahorro: tarjeta.ahorro === 1 ? true : false,
                gasto: tarjeta.gasto === 1 ? true : false,
                descripcion: tarjeta.descripcion,
            };
            console.log('EditarTarjeta', this.tarjetaSeleccionada);
        },


        // CalcularCantidad(porcentaje){
        //     const cantidad = parseFloat(this.cantidadAgregar)
        //     if(!isNaN(this.cantidadAgregar)){
        //         return (porcentaje/100) * cantidad
        //     }else{
        //         return ''
        //     }
        // }
    }


};
</script>

<style>
.card{
    margin: 10px;
}
.editTitulo{
    margin-left: 10px;
}

.card-ahorro{
    background: linear-gradient(to bottom, #82FFBB, white);
}

.card-gasto{
    background: linear-gradient(to bottom, #FF8282, white);
}
.btn {
    color: aliceblue;
    background-color: #21DE4A;
    border-color: black;
}

.btn-margen {
    margin-right: 20px;
    margin-bottom: 20px;
    line-height: 1;
    border-radius: 2;
}

.btn-footer{
    margin-block-end: 10px;
    margin-right: 10px;
}

.mdi-plus-box-outline{
    font-size: 50px;

}



</style>
