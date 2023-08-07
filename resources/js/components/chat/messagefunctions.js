import axios from "axios";

import { reject } from "lodash";
let hostname = "https://" + window.location.hostname;
// let hostname = "http://" + window.location.hostname;
// let hostname = "http://" + window.location.hostname+'/moe/public';

const sendmessage = (data) => {
    return new Promise((resolve, reject) => {
        axios
            .post(hostname + "/backside/shop_owner/sendmessage", { data: data })
            .then((response) => {
                console.log(response);
                resolve(response);
            });
    });
};
const setreadbyuser = (data) => {
    return new Promise((resolve, reject) => {
        axios
            .post(hostname + "/setreadbyuser", { data: data })
            .then((response) => {
                console.log(response);
                resolve(response);
            });
    });
};
const setreadbyshop = (data) => {
    return new Promise((resolve, reject) => {
        axios
            .post(hostname + "/backside/shop_owner/setreadbyshop", {
                data: data,
            })
            .then((response) => {
                console.log(response);
                resolve(response);
            });
    });
};

const sendmessagetouser = (data) => {
    return new Promise((resolve, reject) => {
        axios
            .post(hostname + "/backside/shop_owner/sendmessagetouser", {
                data: data,
            })
            .then((response) => {
                console.log(response);
                resolve(response);
            });
    });
};

const getcurrentchatuser = (id, limit) => {
    return new Promise((resolve, reject) => {
        axios
            .post(hostname + "/backside/shop_owner/getcurrentchatuser", {
                data: id,
                limit: limit,
            })
            .then((response) => {
                resolve(response);
            });
    });
};
const getcurrentchatshops = (id, limit) => {
    return new Promise((resolve, reject) => {
        axios
            .post(hostname + "/getcurrentchatshops", { data: id, limit: limit })
            .then((response) => {
                resolve(response);
            });
    });
};
const sendwhatuserisactive = (id) => {
    return new Promise((resolve, reject) => {
        axios
            .post(hostname + "/sendwhatuserisactive", { data: id })
            .then((response) => {
                resolve(response);
            });
    });
};
const sendwhatshopisactive = (id) => {
    return new Promise((resolve, reject) => {
        axios
            .post(hostname + "/backside/shop_owner/sendwhatshopisactive", {
                data: id,
            })
            .then((response) => {
                resolve(response);
            });
    });
};
const sendwhatuserisoffline = (id) => {
    return new Promise((resolve, reject) => {
        axios
            .post(hostname + "/sendwhatuserisoffline", { data: id })
            .then((response) => {
                resolve(response);
            });
    });
};
const sendwhatshopisofflinefromcustomer = (id) => {
  return new Promise((resolve, reject) => {
      axios
          .post(hostname + "/backside/shop_owner/sendwhatshopisofflinefromcustomer", { data: id })
          .then((response) => {
              resolve(response);
          });
  });
};
const sendwhatshopisoffline = (id) => {
    return new Promise((resolve, reject) => {
        axios
            .post(hostname + "/backside/shop_owner/sendwhatshopisoffline", {
                data: id,
            })
            .then((response) => {
                resolve(response);
            });
    });
};
const gettotalchatcountforuser = () => {
    return new Promise((resolve, reject) => {
        axios.get(hostname + "/gettotalchatcountforuser").then((response) => {
            resolve(response.data.data);
        });
    });
};
const getspecificchatcountforuser = (shop_id) => {
    return new Promise((resolve) => {
        axios
            .get(hostname + "/getspecificchatcountforuser/" + shop_id)
            .then((response) => {
                resolve(response.data.data);
            });
    });
};
const gettotalchatcountforshop = () => {
    return new Promise((resolve, reject) => {
        axios
            .get(hostname + "/backside/shop_owner/gettotalchatcountforshop")
            .then((response) => {
                resolve(response.data.data);
            });
    });
};
const getspecificchatcountforshop = (users_id) => {
    return new Promise((resolve) => {
        axios
            .get(
                hostname +
                    "/backside/shop_owner/getspecificchatcountforshop/" +
                    users_id
            )
            .then((response) => {
                resolve(response.data.data);
            });
    });
};

export const allfrommessagefunction = {
    sendwhatshopisoffline: sendwhatshopisoffline,
    setreadbyshop: setreadbyshop,
    sendwhatshopisactive: sendwhatshopisactive,
    sendwhatuserisoffline: sendwhatuserisoffline,
    sendwhatshopisofflinefromcustomer: sendwhatshopisofflinefromcustomer,
    sendwhatuserisactive: sendwhatuserisactive,
    setreadbyuser: setreadbyuser,
    getcurrentchatshops: getcurrentchatshops,
    sendmessage: sendmessage,
    sendmessagetouser: sendmessagetouser,
    getcurrentchatuser: getcurrentchatuser,
    gettotalchatcountforuser: gettotalchatcountforuser,
    getspecificchatcountforuser: getspecificchatcountforuser,
    gettotalchatcountforshop: gettotalchatcountforshop,
    getspecificchatcountforshop: getspecificchatcountforshop,
};
