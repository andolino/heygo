import axios from 'axios';


export const getPaymentTransactionStudent = async (end_point, payload, func) => {
  try {
      // const res = await axios.get(process.env.MIX_BASE_URL+'/get-teachers-availability', payload);
      const res = await axios.get(end_point, payload).then((res) => {
      return func(res);
      }).catch((error) => {
        console.log(error);
      });
        // return fnc(res);
  } catch (error) {
      console.error(error);
  }
};
