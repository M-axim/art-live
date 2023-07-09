"use strict";

class InfoBlock {

    constructor(title, subTitle, addTitle, editTitle, url) {
        this.title = title
        this.subTitle = subTitle
        this.addTitle = addTitle
        this.editTitle = editTitle
        this.url = url
    }

    get cols() {
        $.ajax({
            url: this.url,
            method: 'get',
            dataType: 'json',
            async: false,

            success: function (MasterCourses) {
                let housesBlock = $(".house");
                housesBlock.text("");
                MasterCourses.forEach(MasterCourse => {
                    housesBlock.append(`                    
                    <div class="house__item" data-house__item="${MasterCourse.id}">
                    <div class="house__action">
                        <button class="house__action-btn house__action-delete" data-MasterCourse-id="${MasterCourse.id}"><img src="img/icon/delete.png" alt=""></button>
                        <button class="house__action-btn house__action-edit" data-MasterCourse-id="${MasterCourse.id}"><img src="img/icon/edit.png" alt=""></button>
                        <button class="house__action-btn house__action-add" data-MasterCourse-id="${MasterCourse.id}"><img src="img/icon/add-photo.png" alt=""></button>
                    </div>
                    <div class="house__item-block"></div>
                    <div class="house__item-img house__item-edit" id="photo-${MasterCourse.id}" data-edit="imageURL" data-img="${MasterCourse.imageURL}" style="background-image: url('img/${MasterCourse.imageURL}')"></div>
                    <div class="overlay"></div>

                    <div class="house__item-tags">
                        <div class="house__item-title house__item-edit" data-edit="title">${MasterCourse.title}</div>
                        <div class="house__item-tag house__item-edit" data-edit="tags_1">${MasterCourse.tags_1}</div>
                        <div class="house__item-tag house__item-edit" data-edit="tags_2">${MasterCourse.tags_2}</div>
                        <div class="house__item-tag house__item-edit" data-edit="tags_3">${MasterCourse.tags_3}</div>
                    </div>
                    <div class="house__item-text house__item-edit" data-edit="text">${MasterCourse.text}</div>
                </div>`)
                })
            }
        });
    }

    col(id) {
        $.ajax({
            url: this.url + `?id=${id}`,
            method: 'get',
            dataType: 'json',
            async: false,
            success: function (MasterCourse) {

                MasterCourse.forEach(MasterCourse => {
                    $(`[data-house__item=${MasterCourse.id}] .house__item-edit`).each(function (item, element) {

                        let attrId = $(element).attr("data-edit")
                        if (attrId !== "imageURL")
                            $(`#addForm #${attrId}`).val(element.innerHTML)

                    })
                })

            }
        });
    }

    delete(id) {
        $.ajax({
            url: this.url + `?id=${id}`,
            method: 'delete',
            dataType: 'json',
            async: false,
            success: function (message) {

            }
        });
    }

    new(formData, id) {
        $.ajax({
            url: this.url + `?id=${id}`,
            method: 'post',
            async: false,
            processData: false,
            contentType: false,
            data: formData,
            success: function (message) {
            }
        });
    }

    setImg(file)
    {
        $.ajax({
            url: this.url,
            method: 'post',
            async: false,
            processData: false,
            contentType: false,
            data: file,
            success: function (message) {
            }
        });
    }

    editCol(body) {
        $.ajax({
            url: this.url,
            method: "patch",
            async: false,
            data: JSON.stringify(body),
            processData: false,
            success: function (message) {
            },
            error: function (error) {
            }
        });
    }

    get form () {
        $("#modal").append(`
                <form action="" method="POST" class="my-modal__form" id="addForm" data-info-id="0" enctype="multipart/form-data">
                <label for="title" class="my-modal__label">
                    <input type="text" name="title" placeholder="Введите заголовок блока" required id="title" class="my-modal__line">
                </label>
                <label for="tags_1" class="my-modal__label">
                    <input type="text" name="tags_1" placeholder="Введите первый тег" required id="tags_1" class="my-modal__line">
                </label>
                <label for="tags_2" class="my-modal__label">
                    <input type="text" name="tags_2" placeholder="Введите второй тег" id="tags_2" class="my-modal__line">
                </label>
                <label for="tags_3" class="my-modal__label">
                    <input type="text" name="tags_3" placeholder="Введите третий тег" id="tags_3" class="my-modal__line">
                </label>
                <label for="text" class="my-modal__label">
                    <input type="text" name="text" placeholder="Введите текст обратной стороны карточки" required id="text" class="my-modal__line">
                </label>
                <label for="imageURL" class="my-modal__label my-modal__file">
                    Загрузите фото
                    <input type="file" name="imageURL" placeholder="Введите путь до изображения" id="imageURL" class="mt-2">
                </label>
                <div class="my-modal__action">
                    <button type="submit" class="btn" id="newHouse">Отправить</button>
                    <button type="submit" class="btn btn-hidden" id="editHouse">Отправить</button>
                </div>
            </form>`)
        $("#modal").append(`
            <form action="" method="POST" class="my-modal__form" id="addPhotoForm" data-info-id="0" enctype="multipart/form-data">
                <label for="imageURL" class="my-modal__label my-modal__file">
                    Загрузите фото
                    <input type="file" name="imageURL" placeholder="Введите путь до изображения" id="imageURL" class="mt-2">
                </label>
                <div class="my-modal__action">
                    <button type="submit" class="btn" id="newPhoto">Отправить</button>
                </div>
            </form>`)
    }

}

class SubmitForm {
    constructor(submitTitle, submitType) {
        this.submitTitle = submitTitle
        this.submitType = submitType
    }

    get form ()
    {
        return `<form action="" method="post" class="my-modal__form" id="submitForm" data-submit-type="${this.submitType}">
                <label for="secondName" class="my-modal__label">
                    <input type="text" name="secondName" placeholder="Введите вашу фамилию" required id="secondName" class="my-modal__line">
                </label>
                <label for="name" class="my-modal__label">
                    <input type="text" name="name" placeholder="Введите ваше имя"  required id="name" class="my-modal__line">
                </label>
                <label for="lastName" class="my-modal__label">
                    <input type="text" name="lastName" placeholder="Введите ваше отчество" required id="lastName" class="my-modal__line">
                </label>
                <label for="telephone" class="my-modal__label">
                    <input type="tel" name="tel" placeholder="Введите ваш номер телефона" required id="telephone" minlength="11" maxlength="11" class="my-modal__line">
                </label>
                <label for="masterCourses" class="my-modal__label">
                    <input type="text" name="masterCourses" placeholder="${this.submitTitle}" required id="masterCourses" class="my-modal__line">
                </label>
                <div class="my-modal__action">
                    <button type="submit" class="btn custom-bg-dark" id="add-modal__submit">Отправить</button>
                </div>
            </form>`
    }

    submit (formData)
    {
        $.ajax({
            url: "../api/record.php",
            method: 'post',
            async: false,
            processData: false,
            contentType: false,
            data: formData,
            success: function (message) {
            }
        });
    }

}

class TeacherExhibitionWork extends InfoBlock
{

    get cols () {
        $.ajax({
            url: this.url,
            method: 'get',
            dataType: 'json',
            async: false,
            success: function (teachers) {

                let count           = 0
                let cards           = 1
                const carousel      = $(".carousel-inner")

                carousel.text("")
                $(".cards .container-xl").text("").append(`
                                                    <h2 class="cards__title" id="cards__title"></h2>`)

                carousel.append(`                            
                    <div class="carousel-item active" id="carousel-item-${cards}">
                        <div class="row no-gutters"></div>
                    </div>`)

                teachers.forEach(teacher => {

                    $(`#carousel-item-${cards} .row.no-gutters`).append(`
                            <a href="" data-item-title="${teacher.title}" data-id-cards="${teacher.id}" class="teacher__cards col-6">
                                <img class="img-fluid house__item-edit" src="img/${teacher.teacherImg}">
                            </a>`)

                    $(".cards .container-xl").append(`
                        <div class="cards__row row" id="${teacher.id}"></div>
                    `)

                    if (teacher.exhibitionWork_1)
                    {
                        $(`#${teacher.id}`).append(`
                        <div class="col-md-6 text-center">
                                <img class="cards__img house__item-edit" src="img/${teacher.exhibitionWork_1}" alt="Одна из работа выбранного учителя">
                            </div>
                        `)
                    }

                    if (teacher.exhibitionWork_2)
                    {
                        $(`#${teacher.id}`).append(`
                        <div class="col-md-6 text-center">
                                <img class="cards__img house__item-edit" src="img/${teacher.exhibitionWork_2}" alt="Одна из работа выбранного учителя">
                            </div>
                        `)
                    }

                    if (teacher.exhibitionWork_3)
                    {
                        $(`#${teacher.id}`).append(`
                        <div class="col-md-6 text-center">
                                <img class="cards__img house__item-edit" src="img/${teacher.exhibitionWork_3}" alt="Одна из работа выбранного учителя">
                            </div>
                        `)
                    }

                    if (teacher.exhibitionWork_4)
                    {
                        $(`#${teacher.id}`).append(`
                        <div class="col-md-6 text-center">
                                <img class="cards__img house__item-edit" src="img/${teacher.exhibitionWork_4}" alt="Одна из работа выбранного учителя">
                            </div>
                        `)
                    }

                    // Здесь мы добавляем наши кнопки для работы с этими фотками
                    $(`#${teacher.id}`).append(`
                            <div class="house__action _teacher">
                                <button class="house__action-btn house__action-delete" data-MasterCourse-id="${teacher.id}"><img src="img/icon/delete.png" alt=""></button>
                                <button class="house__action-btn house__action-edit" data-MasterCourse-id="${teacher.id}"><img src="img/icon/edit.png" alt=""></button>
                                <button class="house__action-btn house__action-add" data-MasterCourse-id="${teacher.id}"><img src="img/icon/add-photo.png" alt=""></button>
                            </div>
                        `)

                    $(".cards__row").first().addClass("cards__row_active")

                    ++count

                    if (count === 2 && (cards * 2) < teachers.length)
                    {
                        carousel.append(`                            
                            <div class="carousel-item" id="carousel-item-${++cards}">
                                <div class="row no-gutters"></div>
                            </div>`)
                        // Обнуляем кол-во фоток в блоке carousel-item
                        count = 0;
                    }

                })
            }
        });
    }

    col(id) {
        $.ajax({
            url: this.url + `?id=${id}`,
            method: 'get',
            dataType: 'json',
            async: false,
            success: function (teachers) {
                teachers.forEach(teacher => {
                    $(`[data-house__item=${teacher.id}] .house__item-edit`).each(function (item, element) {

                        let attrId = $(element).attr("data-edit")
                        if (attrId !== "imageURL")
                            $(`#addForm #${attrId}`).val(element.innerHTML)

                    })
                })

            }
        });
    }

}

let DB
let Form

let submitHouseForm
let submitPhotoForm
let btnNewHouse
let btnAddPhoto
let submitForm
let btnSubmit
let teacherCards

const dataPage = $("body").attr("data-page")
const dataRole = $("body").attr("data-role")

function getFormData(form)
{
    return new FormData($(form).get(0))
}

function createModal(modalName, formName, title, subTitle) {

    let modal           = $(`#${modalName}`)
    let form            = $(`#${formName}`)
    let formTitle       = $("#my-modal__title")
    let formSubTitle    = $("#my-modal__subtitle")
    let body            = $("body")

    $("#addForm").attr("data-type", "add")

    modal.removeClass("h-250")
    $(".my-modal__file").css("display", "flex")

    formTitle.text(`${title}`)

    if (subTitle === null)
        formSubTitle.css("display", "none")
    else
        formSubTitle.text(`${subTitle}`)

    $("#overlay").fadeIn(297, function () {
        modal
            .css("display", "flex")
            .animate({ opacity: 1 }, 198)

        if (formName != null)
            form.css("display", "block")

        body.css("overflow-y", "hidden")
    })


    $(`#${modalName} .my-modal__close, #overlay, .my-modal__close-btn`).click(function () {
        modal.animate({ opacity: 0 }, 198, function () {
            $(this).css("display", "none")
            $("#overlay").fadeOut(297)
        })
        if (formName != null)
            form.css("display", "none")

        body.css("overflow-y", "visible")
    })

}

function removeError (object)
{
    object.css("border", "none")
    let parent  = object.parent()
    let error   = parent.children(".my-modal__error")
    if (error) error.remove()
}

function showError(message, object) {
    object.css("border", "1px solid red")
    const labelError = document.createElement("p")
    labelError.classList.add("my-modal__error")
    labelError.textContent = message
    object.parent().append(labelError)
}

function enableCardsAction() {
    $(".house__action").each(function (elem, index) {
        $(this).css("display", "flex")
    })
}

function getBtnId(btn, attr) {
    return btn.attr(attr);
}

function initActionDelete () {
    $(".house__action-delete").click( function (e) {
        e.preventDefault()
        DB.delete(getBtnId($(this), "data-MasterCourse-id"))

        infoBlockInit()
    })
}

function initActionEdit () {
    $(".house__action-edit").click( function (e) {

        createModal("modal", "addForm", DB.editTitle, null)
        DB.col(getBtnId($(this), "data-MasterCourse-id"))
        $("#addForm").attr("data-info-id", getBtnId($(this), "data-MasterCourse-id"))
        $(".my-modal__file").css("display", "none")

        if (dataPage === "teacher")
            $("#modal").addClass("h-250")
    })
}

function initActionAdd () {
    $(".house__action-add").click( function (e) {
        e.preventDefault()

        createModal("modal", "addPhotoForm", DB.editTitle, null)
        DB.col(getBtnId($(this), "data-MasterCourse-id"))
        $("#addPhotoForm").attr("data-info-id", getBtnId($(this), "data-MasterCourse-id"))
        if (dataPage !== "teacher")
            $("#modal").addClass("h-250")
    })
}

function infoBlockInit()
{
    DB.cols

    if (dataPage === "teacher")
    {
        $("#cards__title").text(`${$(".teacher__cards").first().attr("data-item-title")}`)
        teacherCards = $(".teacher__cards")
    }

    if (dataRole === "admin")
    {
        enableCardsAction()
        initActionDelete()
        initActionEdit()
        initActionAdd()


        if( $("#btnNewHouse").length < 1) {
            $(".main__body").append(`<button class="btn d-inline" id="btnNewHouse">Создать новую карточку</button>`)

            if (dataPage !== "teacher")
            {
                $("#btnNewHouse").css("background-color", $("#btnSubmit").css("background-color"))
                $("#newHouse").css("background-color", $(".main").css("background-color"))
                $("#newPhoto").css("background-color", $(".main").css("background-color"))
            }

        }
    }

}

function init()
{
    if (dataPage === "masters")
    {
        DB = new InfoBlock("Записаться на занятия", "Администратор перезвонит Вам, чтобы уточнить удобное время и дату", "Создание нового мастер-курса", "Обновление мастер курса", "../api/masterCourses.php")
        Form = new SubmitForm("Введите название мастер-класса", "Мастер-курсы")
    }
    else if (dataPage === "courses")
    {
        DB = new InfoBlock("Записаться на занятия", "Администратор перезвонит Вам, чтобы уточнить удобное время и дату", "Создание нового курса", "Обновление курса", "../api/courses.php")
        Form = new SubmitForm("Введите название курса", "Курсы")
    }
    else if (dataPage === "design")
    {
        DB = new InfoBlock("Записаться на арт-вечеринку", "Администратор перезвонит Вам, чтобы уточнить удобное время и дату", "Создание нового арт-дизайна", "Обновление арт-дизайна", "../api/design.php")
        Form = new SubmitForm("Введите название арт-вечеринки", "Арт-вечеринка")
    }
    else if (dataPage === "teacher")
    {
        DB = new TeacherExhibitionWork("", "", "Создание нового преподавателя", "Обновление преподавателя", "../api/teacher.php");
    }
    else {
        DB = null
    }
}

function teacherCardsSlide()
{
    teacherCards.click( function (e){
        e.preventDefault()

        $("#cards__title").text(`${$(this).attr("data-item-title")}`)

        $(".cards__row_active").removeClass("cards__row_active")
        $(`#${$(this).attr("data-id-cards")}`).addClass("cards__row_active")

    })
}

$(document).ready(function() {
    init()
    infoBlockInit()

    if (DB !== null && dataPage !== "teacher")
    {
        DB.form
        $("#modal").append(Form.form)

        submitForm      = $("#submitForm")
        btnSubmit       = $("#btnSubmit")

        btnSubmit.click((e) => {createModal("modal", "submitForm", DB.title, DB.subTitle)})

        submitForm.submit(function (event) {
            event.preventDefault()
            let submit = true
            let telephone = $(`#telephone`)

            removeError(telephone)

            if (!Number(telephone.val())) {
                removeError(telephone)
                showError("Введите номер телефона в следующем формате: 79155552525", telephone)
                submit = false
            }
            if (submit) {

                let formData = getFormData($(this))
                formData.append("submitType", $(this).attr("data-submit-type"))

                Form.submit(formData)
                $(this).trigger("reset");
            }

        })

    }
    else if (dataPage === "teacher")
    {
        teacherCardsSlide()
    }

    btnAddPhoto     = $("#newHouse")
    btnNewHouse     = $("#btnNewHouse")
    submitPhotoForm = $("#addPhotoForm")
    submitHouseForm = $("#addForm")

    btnNewHouse.click((e) => {createModal("modal", "addForm", DB.addTitle, null)})

    // Форма с добавлением новых фоток
    submitPhotoForm.submit(function (event) {
        event.preventDefault()

        let formType = $("#addPhotoForm").attr("data-info-id")

        // Получаем данные введенные в поля формы
        let formData = getFormData($(this))
        formData.append("id", formType)

        DB.setImg(formData)
        $(this).trigger("reset");

        infoBlockInit()
    })

    // Форма, где создаются новые данные в бд
    submitHouseForm.submit(function (event) {
        event.preventDefault()

        let formData = getFormData($(this))

        let formType = $("#addForm").attr("data-info-id")

        if (formType === "0")
            DB.new(formData, formType)
        else
        {
            let data

            if (dataPage === "teacher")
            {
                let cards__img = $(`#${formType} .cards__img`)
                data = {
                    id : formType,
                    teacherImg : $(`[data-id-cards=${formType}] img`).attr("src").slice(5),
                    exhibitionWork_1 : $(cards__img[0]).attr("src").slice(5),
                    exhibitionWork_2 : $(cards__img[1]).attr("src").slice(5),
                    exhibitionWork_3 : $(cards__img[2]).attr("src").slice(5),
                    exhibitionWork_4 : $(cards__img[3]).attr("src").slice(5),
                    title : formData.get("title")
                }
            }
            else {
                data = {
                    id : submitHouseForm.attr("data-info-id"),
                    title : formData.get("title"),
                    tags_1 : formData.get("tags_1"),
                    tags_2 : formData.get("tags_2"),
                    tags_3 : formData.get("tags_3"),
                    text : formData.get("text"),
                    imageURL : {
                        name : $(`#photo-${formType}`).attr("data-img")
                    }
                }
            }

            DB.editCol(data)
        }

        // сбрасываем введенные пользователем данные
        $(this).trigger("reset");

        // Обновляем информацию на странице
        infoBlockInit()
    })

});

