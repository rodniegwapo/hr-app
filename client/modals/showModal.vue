<template>
    <div>
        <a-modal :visible="display" title="User Information" class="flex  justify-content-center" @cancel="close"  >
            <div class="p-2" style="width:500px">
                Name: {{user['firstname'] + " " + user['lastname']}}
            </div>
            <div class="p-2" style="width:500px">
                Email: {{user['email']}}
            </div>
            <div class="p-2" style="width:500px">
                Role: <span class="">{{user['role']['role']}}</span>
            </div>
            <template slot="footer">
                <a-button class=" " key="back" @click="close">
                    Back
                </a-button>
            </template>   
        </a-modal>
    </div>
</template>

<script>
export default {
    props: {
        display: {
            type: Boolean,
            default: true
        },
        user: {
            type: Object,
            default : () => {}
        }
    },
    data () {
        return {}
    },
    methods : {
        close () {
           this.$emit('close',null)
        },
        dismiss(){
            this.$emit('close',false)
        }
    }
}
</script>