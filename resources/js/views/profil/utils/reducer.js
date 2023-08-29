const initialState = {
    programs: [],
};

export const DISPATCHER = {
    FETCH: 'fetch'
}


export function profilReducer(state, dispatcher) {
    switch (dispatcher.type) {
        case DISPATCHER.FETCH:
            return dispatcher.payload;

        default:
            throw new Error();
  }
}
