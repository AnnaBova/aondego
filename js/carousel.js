var carousel = $('.staffCarousel');
var createdStaffs = [];
var currentStaff = $('.currentStaff');
var imgCurrentStaff = $('.imgCurrentStaff');
var imgInnerSlideCurrentStaff = $('.imgInnerSlideCurrentStaff');
var imgInnerSlideStaffLeft = $('.imgInnerSlideStaffLeft');
var imgInnerSlideStaffRight = $('.imgInnerSlideStaffRight');
var time_animate = 400;
var middleItem = 0;

function createStaffCarousel(staffs) {
    middleItem = Math.floor(staffs.length/2);
    if ( !isNaN(middleItem) && middleItem !== 'undefined' ) {
        if ( staffs.length > 1 ) {
            staffs.forEach(function(item, key){
                var newStaff = $('.otherStaff0').clone();
                newStaff.css({'background-image': 'url('+item.img+')'}).addClass("key"+key);
                createdStaffs.push(newStaff);
            });
        }
        var name = staffs[middleItem].name;
        if (typeof name !== 'undefined') {
            currentStaff.find('.staffName').text(name);
        }

        imgCurrentStaff.css({'background-image': 'url('+staffs[middleItem].img+')'}).find('.staffName').text();
        if (typeof createdStaffs[middleItem - 2] !== 'undefined') {
            imgInnerSlideStaffLeft.append(createdStaffs[middleItem - 2].css({display: 'block'})[0]);
        }
        if (typeof createdStaffs[middleItem - 1] !== 'undefined') {
            imgInnerSlideStaffLeft.append(createdStaffs[middleItem - 1].css({display: 'block'})[0]);
        }
        if (typeof createdStaffs[middleItem + 1] !== 'undefined') {
            imgInnerSlideStaffRight.append(createdStaffs[middleItem + 1].css({display: 'block'})[0]);
        }
        if (typeof createdStaffs[middleItem + 2] !== 'undefined') {
            imgInnerSlideStaffRight.append(createdStaffs[middleItem + 2].css({display: 'block'})[0]);
        }
        getStaffFreeTime(staffs[middleItem].id);
    }
}

function move_staff_carousel(button,right = false, left = false) {
    var newCurrentStaffImg = clone_current_staff(imgCurrentStaff);
    var unique_class_current_staff = add_unique_class(newCurrentStaffImg);
    var new_width = change_the_block_width('imgInnerSlideCurrentStaff', 140);
    var left_block_width = change_the_block_width('imgInnerSlideStaffLeft', 180);
    var right_block_width = change_the_block_width('imgInnerSlideStaffRight', 180);
    var name = staffs[middleItem].name;
    var description = staffs[middleItem].description;
    if (typeof name !== 'undefined') {
        currentStaff.find('.staffName').text(name);
    }
//		if (typeof description !== 'undefined') {
//			currentStaff.find('.staffRole').text(description);
//		}
    getStaffFreeTime(staffs[middleItem].id);
    if (right) {
        if (typeof createdStaffs[middleItem - 2] !== 'undefined') {
            var new_left_staff =  createdStaffs[middleItem - 2].clone().css({display: 'block'});
            prepend_staff('imgInnerSlideStaffLeft', new_left_staff[0], 90);
        }
        var new_right_staff =  createdStaffs[middleItem + 1].clone().css({display: 'block', opacity: 0});
        prepend_staff('imgInnerSlideStaffRight', new_right_staff[0], 90);

        prepend_staff('imgInnerSlideCurrentStaff', newCurrentStaffImg[0], 140);
        $('.imgInnerSlideCurrentStaff').animate({
            left: '+=140',
        },time_animate);
        $('.imgInnerSlideStaffLeft').animate({
            left: '+=90',
        },time_animate);
        $('.imgInnerSlideStaffRight').animate({
            left: '+=90',
        },time_animate);
        $('.imgInnerSlideStaffRight').children().last().animate({
            opacity: '0',
        },time_animate);
        new_right_staff.animate({
            opacity: '1',
        },time_animate);

        clear_after_move(button, unique_class_current_staff, time_animate, false, true);
    }
    if (left) {
        if (typeof createdStaffs[middleItem + 2] !== 'undefined') {
            var new_right_staff =  createdStaffs[middleItem + 2].clone().css({display: 'block'});
            append_staff('imgInnerSlideStaffRight', new_right_staff[0], false, 90);
        }

        var new_right_staff =  createdStaffs[middleItem - 1].clone().css({display: 'block', opacity: 0});
        append_staff('imgInnerSlideStaffLeft', new_right_staff[0], false, 90);

        append_staff('imgInnerSlideCurrentStaff', newCurrentStaffImg[0]);
        $('.imgInnerSlideCurrentStaff').animate({
            left: '-=140',
        },time_animate);
        $('.imgInnerSlideStaffLeft').animate({
            left: '-=90',
        },time_animate);
        $('.imgInnerSlideStaffRight').animate({
            left: '-=90',
        },time_animate);
        $('.imgInnerSlideStaffRight').children().last().animate({
            opacity: '1',
        },time_animate);
        new_right_staff.animate({
            opacity: '1',
        },time_animate);

        clear_after_move(button, unique_class_current_staff, time_animate, true);
    }

}

function clone_current_staff(target) {
    var newCurrentStaffImg = target.clone()
    newCurrentStaffImg.css({'background-image': 'url('+staffs[middleItem].img+')'});
    return newCurrentStaffImg;
}

function add_unique_class(target) {
    var unique_class = Math.random().toString(36).substr(2, 5);
    target.addClass(unique_class);
    return unique_class;
}

function change_the_block_width(block_class, value) {
    var block = $('.'+block_class);
    var current_block_width = block.width();
    if (value > 0) {
        var new_width = parseInt(current_block_width) + parseInt(value) +'px'
    } else {
        var new_width = parseInt(current_block_width) - Math.abs(parseInt(value)) +'px'
    }
    block.css({width: new_width});

    return new_width;
}

function prepend_staff(parent_class, child, left = 0, right = 0) {
    var parent = $('.'+parent_class);
    parent.prepend(child);
    if (left != 0) {
        parent.css({left: '-'+parseInt(left)+'px'});
    }
    if (right != 0) {
        parent.css({left: '+'+parseInt(left)+'px'});
    }
}

function append_staff(parent_class, child, left = 0, right = 0) {
    var parent = $('.'+parent_class);
    parent.append(child);
    if (left != 0) {
        parent.css({left: '-'+parseInt(left)+'px'});
    }
}

function clear_after_move(button, unique_class_current_staff, time_animate, clear_left = false, clean_right = false) {
    button.css({'pointerEvents': 'none'});
    setTimeout(function(){
        change_the_block_width('imgInnerSlideCurrentStaff', -140);
        change_the_block_width('imgInnerSlideStaffLeft', -180);
        change_the_block_width('imgInnerSlideStaffRight', -180);
        if (clear_left) {
            $('.imgInnerSlideCurrentStaff').css({left:0});
            $('.imgInnerSlideStaffRight').css({left:0});
            $('.imgInnerSlideStaffLeft').css({left:0});
            $('.imgInnerSlideStaffRight').children().first().remove();
            $('.imgInnerSlideStaffLeft').children().first().remove();
        }

        if (clean_right) {
            $('.imgInnerSlideStaffRight').children().last().remove();
            $('.imgInnerSlideStaffLeft').children().last().remove();
        }


        $('.imgInnerSlideCurrentStaff').find('*:not(".'+unique_class_current_staff+'")').remove();
        button.css({'pointerEvents': 'auto'});
    }, parseInt(time_animate) + 20);
}
//--------------------------- arrow th the right -----------------------------------------------

$('.arrowRight').on('click', function(event){
    if ( middleItem > 0 ) {
        middleItem = middleItem - 1;
        if(middleItem === 0) {
            $(this).hide();
        }
        $('.arrowLeft').show()
    }else{
        $(this).hide();
    }
    move_staff_carousel($(this),true);
});

//-------------------------- arrow to the left -----------------------------------------------

$('.arrowLeft').on('click', function(event){
    if ( middleItem < staffs.length ) {
        middleItem = middleItem + 1;
        if(middleItem === staffs.length) {
            $(this).hide();
        }
        $('.arrowRight').show()
    }else{
        $(this).hide();
    }
    move_staff_carousel($(this),false, true);
});
