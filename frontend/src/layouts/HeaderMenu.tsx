import { NavLink, useNavigate } from "react-router-dom";
import { Button } from "../components/Button";

interface HeaderMenuProps {
  className?: string;
}

function HeaderMenu({ className }: HeaderMenuProps) {
  const navigate = useNavigate();
  return (
    <li className={`flex items-center ${className}`}>
      <NavLink to="/home" className="text-sm text-neutral-700 hover:underline">
        ホーム
      </NavLink>
      <NavLink
        to="/diagnosis"
        className="text-sm text-neutral-700 hover:underline"
      >
        性能診断
      </NavLink>
      <NavLink
        to="/feedback"
        className="text-sm text-neutral-700 hover:underline"
      >
        ご意見・ご感想
      </NavLink>
      <Button
        variant="fillPrimary"
        size="sm"
        onClick={() => navigate("/diagnosis")}
      >
        診断する
      </Button>
    </li>
  );
}

export default HeaderMenu;
