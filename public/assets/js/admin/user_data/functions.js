const to_slug = (str) => {
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();

    // xóa dấu
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');

    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, '');

    // Xóa khoảng trắng thay bằng ký tự -
    str = str.replace(/(\s+)/g, '-');

    // xóa phần dự - ở đầu
    str = str.replace(/^-+/g, '');

    // xóa phần dư - ở cuối
    str = str.replace(/-+$/g, '');

    // return
    return str;
};

const showLoading = () => {
    return $('body').append(`<div id="overlay"></div>`);
};

const hideLoading = (time = 5000) => {
    setTimeout(() => {
        $('#overlay').remove();
    }, time);
};

// Kỹ thuật throttle
/**
 * TODO: là 1 kỹ thuật kiểm soát số lần thực thi
 * Hoạt động theo nguyên tắc
 * Đầu tiên: gọi làm throttle(1 function call back, delayTime) sẽ set lastTime = 0 và trả về 1 function
 * Trong function return getTimeNow
 * Lần 1: kiểm tra getTimeNow - lastTime < delayTime (Pass) vì last lúc này có giá trị = 0 nên sẽ set lastTime = getTimeNow
 * Lần 2: kiểm tra getTimeNow - lastTime < delayTime.
 * Nếu trong thời gian delayTime vẫn gọi hành động trong throttle thì sẽ Fail
 * Do ko thoả mãn getTimeNow - lastTime < delayTime . lasTime lúc này đang có giá trị = getTimeNow từ lần gọi trước đó
 * Nếu như gọi hành động sau thời gian set delayTime thì quay lại Lần 1. Do thoả mãn getTimeNow - lastTime < delayTime
 *
 * Lưu ý: nếu như reload page thì lastTime sẽ tự reset về 0 vì đây là 1 biến tĩnh ko lưu vào db hay session.
 *
 * ==> nên dùng lodash vì kỹ thuật được tích hợp sẵn. Còn function bên dưới là nghiên cứu để hiểu bản chất của kỹ thuật
 */
const throttle = (fn, delay) => {
    delay = delay || 0;
    let last = 0;

    return () => {
        const now = new Date().getTime();
        if (now - last < delay) {
            return;
        }

        last = now;
        fn();
    };
};
// Kỹ thuật debounce
/**
 * TODO: là 1 kỹ thuật kiểm soát số lần thực thi như throttle
 * Không giống với throttle sau bao lâu 1 gọi 1 lần
 * Debounce sẽ thực thi dựa trên setTimeout và delay được truyền vào
 * Phương pháp:
 * Tạo 1 biến timeId
 * return về function
 * Thực thi:
 * Đầu tiên debounce cũng sẽ setting các biến cần như timeId, delay = delay truyền
 * Lần đàu do timeId chưa được set giá trị nên lúc này default = null ==> sẽ gán timeId = setTimeout
 * Nếu như người dùng gọi hành động liên tục trong thời gian setTimeout chưa chạy
 * thì lúc này sẽ clearTimeout và set timeId = null(xoá setTimeout được set trước đó). Và sẽ gán cho timeId 1 setTimeout mới tương ứng
 * setTimeout chỉ chạy khi mà hành động đó kết thúc sau delayTime được set
 * Nếu như người dùng click mãi thì sẽ lặp lại hành động clearTimeout và tạo mới setTimeout mãi cho đến khi người dùng ngừng click.
 *
 * Lưu ý:
 * như kỹ thuật throttle nên gọi tự lodash do đây là 1 thư viện lodash do có cộng đồng cải tiến và hỗ trợ.
 * hàm bên dưới viết để tham khảo quá trình hoạt động
 */
const debounce = (fn, delay) => {
    delay = delay || 0;
    let timeId;

    return () => {
        if (timeId) {
            clearTimeout(timeId);
            timeId = null;
        }

        timeId = setTimeout(() => {
            fn();
        }, delay);
    };
};

const getProductTryURL = (params = '') => {
    let parsedUrl = new URL(window.location.href);
    // let categories = parsedUrl.searchParams.get('categories') || '';
    // categories = categories.split(',');

    // if (Array.isArray(categories) && categories.length) {
    //     if (id == 'all') {
    //         categories = [];
    //     } else if (!categories.includes(id)) {
    //         categories.push(id);
    //     } else {
    //         categories = categories.filter(function (index) {
    //             return index !== id;
    //         });
    //     }

    //     parsedUrl.searchParams.set('categories', categories.join(','));
    //     parsedUrl.searchParams.set('page_no', 1);
    // }

    let getParams = parsedUrl.searchParams.get(params) || '';
    if (getParams.length) {
        parsedUrl.searchParams.set(params, getParams);
    }

    return parsedUrl.href;
};
