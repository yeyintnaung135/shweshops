<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <form id="app">

                        <section v-if="step == 1">
                            <h3>Step 1</h3>
                            <input type="text" placeholder="what is your name?" class="form-control form-control-lg">
                        </section>

                        <section v-if="step == 2">
                            <h3>Step 2</h3>
                            <input type="tel" placeholder="what is your phone number?"
                                   class="form-control form-control-lg">
                            <input type="email" placeholder="what is your email address?"
                                   class="form-control form-control-lg">
                        </section>

                        <section v-if="step == 3">
                            <h3>Step 3</h3>
                            <textarea name="" id="" placeholder="type your message"
                                      class="form-control form-control-lg"></textarea>
                        </section>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    data() {

        return {
            step: 1,
            totalsteps: 3,
            form: {
                name: null,
                email: null,
                phone: null,
                message: null
            }
        }
    }


}

;

</script>
