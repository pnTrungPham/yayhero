import { BigMan } from "../types/bigMan.type";
import wpEndpoint from "./wpRes";

export const getBigMans = async (): Promise<BigMan[]> => {
  return wpEndpoint
    .get("/heroes")
    .then(function (res) {
      return res.data.data;
    })
    .catch(function (error) {
      console.log(error);
    });
};

export const addBigMan = async (
  bigMan: Omit<BigMan, "id">
): Promise<BigMan[]> => {
  return wpEndpoint
    .post("/heroes", {
      username: bigMan.username,
      age: bigMan.age,
    })
    .then(function (res) {
      return res.data.data;
    })
    .catch(function (error) {
      console.log(error);
    });
};

export const deleteBigMan = async (bigManID: number): Promise<BigMan[]> => {
  return wpEndpoint
    .delete(`/heroes/${bigManID}`)
    .then(function (res) {
      return res.data.data;
    })
    .catch(function (error) {
      console.log(error);
    });
};

export const updateBigMan = async (bigMan: BigMan): Promise<BigMan[]> => {
  return wpEndpoint
    .patch(`/heroes/${bigMan.id}`, {
      username: bigMan.username,
      age: bigMan.age,
    })
    .then(function (res) {
      return res.data.data;
    })
    .catch(function (error) {
      console.log(error);
    });
};
