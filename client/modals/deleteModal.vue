<template>
    <div>
        <Dialog :visible="display" v-if="display" class="flex justify-content-center" @click="close"  >
            <template #header>
               
            </template>
            <h3 class="px-2">Are you sure you to delete this user ?</h3>
            <template #footer>
                <Button  class="mx-4"  label="No"  autofocus @click="remove" />
                <Button  class="mx-4"  label="Delte"  autofocus @click="dismiss" />
            </template>
        </Dialog>
    </div>
</template>

<script>
export default {
    props: {
        display: {
            type: Boolean,
            default: false
        },
        user: {
            type: Object,
            default : () => {}
        }
    },
    data () {
        return {

        }
    },
    methods: {
        remove(){

        },
        dismiss(){
            
        }
    }
}
</script>