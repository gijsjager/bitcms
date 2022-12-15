function store(id, elm){
    $.post(window.location.href, {id: id, content: $(elm).val()});
}

function submitTranslation(e, id, elm){
    if(e.code === 'NumpadEnter' || e.code === 'Enter'){
        store(id, elm)
    }
}
