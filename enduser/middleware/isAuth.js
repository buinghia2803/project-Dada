const Cookie = process.client ? require("js-cookie") : undefined;

export default function ({store, redirect, route}) {
    // If the user is not authenticated
    let cookie = Cookie && Cookie.get("auth_user");
    if (cookie && store.$auth.loggedIn) {
        return redirect(`/mypage`);
    }
}
