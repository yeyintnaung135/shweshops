<template>
    <div class="col-md-6 p-0">
        <div class="form-group row">
            <div class="col-12">
                <label v-if="this.ew == false" style="font-size: 14px"
                    >Weight
                </label>
                <label v-else style="font-size: 14px; color: red"
                    >Weight
                </label>
                <multi
                    v-model="weight_child"
                    :options="option_weight"
                    :multiple="true"
                    placeholder="Pick some"
                    track-by="name"
                    @select="inputHandler"
                    @remove="removeHandler"
                    label="name"
                ></multi>
            </div>
        </div>
        <div
            class="form-group row"
            v-for="g in this.weight_child"
            :key="g.index"
        >
            <div class="col-6">
                <label>Name</label>

                <div class="form-control" style="">
                    {{ g.name }}
                </div>
            </div>
            <div class="col-6">
                <label v-if="g.error == false" style="font-size: 14px"
                    >Counts<span class="sn-required-asterick">*</span>
                </label>
                <label v-else style="font-size: 14px; color: red"
                    >Counts<span class="sn-required-asterick">*</span>
                </label>

                <input
                    type="number"
                    class="form-control"
                    v-model="g.value"
                    v-bind:class="{ 'border-danger': g.error }"
                    placeholder="Enter Count"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect-with-duplicates";
import vue2Dropzone from "vue2-dropzone";
export default {
    props: ["editdataweight", "weight_unit_child", "errorprops"],
    name: "Ykweight",
    data: function () {
        return {
            ew: false,

            gorother: "အောင်စ",
            weight_child: "",
            option_weight: [
                { name: "အောင်စ", value: 0, error: false },
                { name: "ကျပ်သား", value: 0, error: false },
                { name: "ဂရမ်", value: 0, error: false },
                { name: "မတ်", value: 0, error: false },
                { name: "ပဲ", value: 0, error: false },
                { name: "မူး", value: 0, error: false },
                { name: "ရွေး", value: 0, error: false },
            ],
        };
    },
    components: {
        multi: Multiselect,
    },
    beforeMount() {},

    mounted() {
        console.log(this.editdataweight);

        console.log(this.weight_unit_child);
        console.log(this.editdataweight);
        if (this.editdataweight != undefined && this.editdataweight != "temp") {
            this.weight_child = JSON.parse(this.editdataweight);
            // this.passchildtoparent();
        } else {
            this.weight_child = [];
        }
    },

    methods: {
        inputHandler(selectedOption, id) {
            this.weight_child.push(selectedOption);
        },
        removeHandler(removedOption, id) {
            // this.weight_child.splice(id, 1);
        },
        passchildtoparent() {
            this.$emit("forparent", {
                weight: this.weight_child,
                unit: this.gorother,
            });
        },
        clearerror() {
            this.$emit("errorhasweight", false);
        },
    },
};
</script>

<style scoped></style>
