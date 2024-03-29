import axios from 'axios';

export const getTeachingStrategy = async (fnc, payload) => {
  try {
      const res = await axios.post(process.env.MIX_BASE_URL+'/get-teaching-strategy/all', payload);
      console.log(res.data, ' res.data');
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

export const getWorksheet = async (fnc) => {
  try {
      const res = await axios.get(process.env.MIX_BASE_URL+'/get-worksheet-image');
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


export const getCommunicationApp = async (fnc) => {
  try {
      const res = await axios.get(process.env.MIX_BASE_URL+'/get-comm-app');
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

export const saveCancelLessonMsg = async (fnc, payload) => {
  try {
      const res = await axios.post(process.env.MIX_BASE_URL+'/save-cancel-lesson-msg', payload);
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

export const getDataPlatform = async (fnc) => {
  try {
      const res = await axios.get(process.env.MIX_BASE_URL+'/get-comm-app');
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



