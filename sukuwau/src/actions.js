import {
  SET_FAMILY_TREE,
  BROWSE_HORSE
} from './constants';

export const setFamilyTree = (tree) => ({
  type: SET_FAMILY_TREE,
  payload: tree
});

export const browseHorse = (id) => ({
  type: BROWSE_HORSE,
  payload: id
});
