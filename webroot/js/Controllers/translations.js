function store(key, elm){
    $.post(window.location.href, {
        template_key: key,
        locale: $(elm).data('locale'),
        content: $(elm).val()
    });
}

function submitTranslation(e, key, elm){
    if(e.nativeEvent.inputType === "insertLineBreak") return;

    if(e.code === 'NumpadEnter' || e.code === 'Enter'){
        store(key, elm);
        e.preventDefault();
        return false;
    }
}
