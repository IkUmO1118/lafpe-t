import { Outlet } from "react-router-dom";
import Header from "./Header";
import Footer from "./Footer";

function AppLayout() {
  return (
    <div className="h-screen bg-neutral-50">
      <Header />
      <Outlet />
      <Footer />
    </div>
  );
}

export default AppLayout;
