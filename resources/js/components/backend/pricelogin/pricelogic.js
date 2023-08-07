const pricelogicsn=(price)=>{
    if (price.length < 5) {
       return price;
    } else {
        if (price.toString().length > 10) {
          return 'overflow'
        }
        var n = ("000000000" + price)
            .substr(-10)
            .match(/^(\d{5})(\d{1})(\d{1})(\d{3})$/);

        if (!n) return;

        var priceinword = "";

        if (n[1] != 0) {
            if (
                (n[1][0] != "0" &&
                    n[1][1] == "0" &&
                    n[1][2] == "0" &&
                    n[1][3] == "0" &&
                    n[1][4] == "0") ||
                (n[1][1] != "0" &&
                    n[1][2] == "0" &&
                    n[1][3] == "0" &&
                    n[1][4] == "0") ||
                (n[1][2] != "0" && n[1][3] == "0" && n[1][4] == "0") ||
                (n[1][3] != "0" && n[1][4] == "0")
            ) {
                priceinword += "သိန်း" + Number(n[1]) + " ";
            } else if (n[1][0] && n[1][1]) {
                priceinword +=
                    (Number(n[1]) || n[1][0] + n[1][1]) + "သိန်း";
            }
        }

        function htaungCheck() {
            if (n[4] != 0) {
                return true;
            }
        }

        function thaungCheck() {
            if (n[3] != 0 || n[4] != 0) {
                return true;
            }
        }

        if (
            n[1][0] == "0" &&
            n[1][1] == "0" &&
            n[1][2] == "0" &&
            n[1][3] == "0" &&
            n[1][4] == "0"
        ) {
            priceinword += n[2] != 0 ? n[2][0] + "သောင်း" : "";
            priceinword +=
                (n[3] != 0 ? n[3][0] + "ထောင်" : "") +
                (htaungCheck() ? "ဝန်းကျင်" : "");
        } else {
            priceinword +=
                (n[2] != 0 ? n[2][0] + "သောင်း" : "") +
                (thaungCheck() ? "ဝန်းကျင်" : "");
        }

       return priceinword.trim()
    }
}

export default pricelogicsn;
