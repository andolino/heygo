


import axios from 'axios';

export const getLessonCategory = async (fnc) => {
  // return  () => {
      try {
          const res = await axios.get('teacher-lobby-lesson-plan');
          return fnc(res.data);
         //  console.log(res);
         //  setData(res.data);
          console.log(res.data);
      } catch (error) {
          console.error(error);
      }
  // };
};

export const getStudentsLevel = async (fnc) => {
  // return  () => {
      try {
          const res = await axios.get('students-level');
          return fnc(res.data);
         //  console.log(res);
         //  setData(res.data);
          console.log(res.data);
      } catch (error) {
          console.error(error);
      }
  // };
};

// export const getLessonCategory = async () => { 
//   await axios.get('teacher-lobby-lesson-plan').then((res)=>{
//     return res.data;
//   });
// }

