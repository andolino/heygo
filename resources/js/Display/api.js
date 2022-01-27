import axios from 'axios';

export const getLessonCategory = async (fnc) => {
    try {
        const res = await axios.get(process.env.MIX_BASE_URL+'/teacher-lobby-lesson-plan');
        // console.log(res.data);
          return fnc(res.data);
    } catch (error) {
        console.error(error);
    }
};

export const getStudentsLevel = async (fnc) => {
      try {
          const res = await axios.get(process.env.MIX_BASE_URL+'/students-level');
          return fnc(res.data);
      } catch (error) {
          console.error(error);
      }
};

export const saveTeachingStrategy = async (data, config) => {
      try {
          const res = await axios.post(process.env.MIX_BASE_URL+'/save-teaching-strategy', data);
          console.log(res);
          if (res.data.status == 1) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: res.data.msg,
                showConfirmButton: false,
                timer: 2000
              }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                  window.location.reload();
                }
              });
          } else {
            console.error('Error');
          }
      } catch (error) {
          console.error(error);
      }
};

export const getTeachingStrategyView = async (fnc, id) => {
  try {
      const res = await axios.post(process.env.MIX_BASE_URL+'/get-teaching-strategy/view', { 'id': id });
      // console.log(res.data);
      return fnc(res.data);
  } catch (error) {
      console.error(error);
  }
};

export const saveRatingsPerStratPlan = async (payload) => {
  try {
      const res = await axios.post(process.env.MIX_BASE_URL+'/save-ratings-per-strat-plan', payload);
      console.log(res);
  } catch (error) {
      console.error(error);
  }
};
