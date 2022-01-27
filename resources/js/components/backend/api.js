import axios from 'axios';

export const getTeachingStrategy = async (fnc) => {
  try {
      const res = await axios.post(process.env.MIX_BASE_URL+'/get-teaching-strategy/all');
      // console.log(res.data);
      return fnc(res.data);
    //   if (res.data.status == 1) {
        
    //   } else {
    //     console.error('Error');
    //   }
  } catch (error) {
      console.error(error);
  }
};

export const getTeachingStrategyBookmark = async (fnc) => {
  try {
      const res = await axios.post(process.env.MIX_BASE_URL+'/get-teaching-strategy/bookmark');
      // console.log(res.data);
      return fnc(res.data);
    //   if (res.data.status == 1) {
        
    //   } else {
    //     console.error('Error');
    //   }
  } catch (error) {
      console.error(error);
  }
};



