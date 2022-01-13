import axios from 'axios';

export const getLessonCategory = async (fnc) => {
      try {
          const res = await axios.get('teacher-lobby-lesson-plan');
          return fnc(res.data);
      } catch (error) {
          console.error(error);
      }
};

export const getStudentsLevel = async (fnc) => {
      try {
          const res = await axios.get('students-level');
          return fnc(res.data);
      } catch (error) {
          console.error(error);
      }
};

export const saveTeachingStrategy = async (data, config) => {
      try {
          const res = await axios.post('save-teaching-strategy', data, config);
          return [];
      } catch (error) {
          console.error(error);
      }
};