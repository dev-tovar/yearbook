export default {
    data() {
        return {
            rules_form: {
                required: v => !!v || "This field is required",
                numbers: v => /^([0-9])*$/.test(v) || "This field must be numeric",
                email: v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                    
            },
        }
    },

};