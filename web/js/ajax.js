function populateForm(formId, entity) {
    for (var property in entity) {
        if (!entity.hasOwnProperty(property)) {
            continue;
        }

        $('#' + formId + '_' + property).val(entity[property]);
    }
}