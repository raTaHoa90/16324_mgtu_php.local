'use strict';

const 
    EXT_PIC = ['png','jpg','jepg','gif','webp','ico'],
    EXT_DOC = ['doc','docx','odt','pdf','xml'];

var catalogs = {
    path: '',
    userDir: '',
    addError: function(message){
        let tmpl = error_templ.content.cloneNode(true);
        $('span', tmpl).html(message);

        let div = tmpl.querySelector('.error');
        $('.errors').append(div);

        setTimeout(_=>div.remove(), 3000);
    },

    loadDir: function(){
        $('.files').html('');
        $.post('/admin/catalogs/getCatalogs', {path: this.path}, req => {
            if(req.error){
                this.addError(req.error);
                return;
            }

            // Тут будет вывод каталогов и файлов
            req.forEach(entity => {
                if(entity.type == 'dir')
                    this.dirView(entity.name);
                else
                    this.fileView(entity);
            });
        }, 'json');
    },

    createDir: function(){
        //let dirname = document.getElementById('dirname').value;
        let dirname = $('#dirname').val();
        if(!/^[\wа-яА-ЯёЁ_+=\(\) !\.-]+$/i.test(dirname)){
            this.addError('В имени содержаться недопустимык символы');
            return;
        }

        $.post('/admin/catalogs/createDir', {path: this.path, dirname}, req => {
            if(req.ok)
                this.dirView(dirname);
            else if(req.error)
                this.addError(req.error)
            $('#dirname').val('');
        }, 'json');
    },

    uploadFile: function(){
        let formData = new FormData();
        if(upFile.files.length == 0){
            this.addError('Нет файлов для отправки');
            return;
        }

        for(let file of upFile.files)
            formData.append('upFile[]', file);

        $('#upFile').val('');

        formData.append('path', this.path);
        $.ajax({
            type: 'POST',
            url: '/admin/catalogs/uploadFile',
            cache: false,
            processData: false,
            contentType: false,
            data: formData,
            dataType: 'json',
            success: req => {
                //console.log(req);
                if(req.error){
                    this.addError(req.error);
                    return;
                }
                req.forEach(fileData => {
                    this.fileView(fileData);
                });
            }
        });
    },

    fileView: function(data){
        const
            fullpath = '/storage/' + this.userDir + '/' + this.path + '/' + data.name;

        let tmpl = file_templ.content.cloneNode(true),
            div = tmpl.querySelector('.file'),
            img = div.querySelector('img');
        
        if(EXT_PIC.includes(data.ext))
            img.src = fullpath;
        else if(EXT_DOC.includes(data.ext))
            img.src = '/imgs/ext/icon_' + data.ext + '.png';
        else if(data.ext == 'txt')
            img.src = 'imgs/ext/icon_txt.webp';

        $('a', div).html(data.name).click(e => open(fullpath, '_blank') );

        $('.file-info i', div).html(data.size);
        $('.file-info span', div).html(data.created_at);

        $('.files').append(div);
    },

    dirView: function(name){
        let tmpl = dir_templ.content.cloneNode(true),
            div = tmpl.querySelector('.dir');
        
        $('a', div).html(name).click(e => {
            if(name == '..') {
                if(this.path == '') return;

                let paths = this.path.split('/');
                paths.pop();
                this.path = paths.join('/');
            } else 
                this.path += '/' + name;
            
            this.loadDir();
        });

        $('.files').append(div);
    }
}

$(function(){ // регистрируем функцию, которую необходимо выполнить сразу как только документ будет готов
    catalogs.loadDir();
});