


import axios from 'axios';

export const getLessonCategory = function() { 
  return axios.get('teacher-lobby-lesson-plan').then((res)=>{
    return res.data;
  });
}

